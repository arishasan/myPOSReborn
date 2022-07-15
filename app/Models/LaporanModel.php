<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use RecursiveIteratorIterator;
use RecursiveArrayIterator;

class LaporanModel extends Model
{
    use HasFactory;


    static function modify_tree_barang_fixed($tree) {

        $array_iterator = new RecursiveArrayIterator($tree);
        $recursive_iterator = new RecursiveIteratorIterator($array_iterator, RecursiveIteratorIterator::CHILD_FIRST);

        foreach ($recursive_iterator as $key => $value) {
            if (is_array($value) && array_key_exists('children', $value)) {
                $array_with_children = $value;

                $array_with_children_count = $array_with_children['count'];

                foreach ($array_with_children['children'] as $children) {
                    $array_with_children_count = $array_with_children_count + $children['count'];
                }

                $array_with_children['count'] = $array_with_children_count;

                // 

                $array_with_children_nominal = $array_with_children['nominal'];

                foreach ($array_with_children['children'] as $children) {
                    $array_with_children_nominal = $array_with_children_nominal + $children['nominal'];
                }

                $array_with_children['nominal'] = $array_with_children_nominal;

                // 

                $current_depth = $recursive_iterator->getDepth();

                for ($sub_depth = $current_depth; $sub_depth >= 0; $sub_depth--) {
                    $sub_iterator = $recursive_iterator->getSubIterator($sub_depth);

                    if ($sub_depth === $current_depth) {
                        $value = $array_with_children;
                    } else {
                        $value = $recursive_iterator->getSubIterator(($sub_depth + 1))->getArrayCopy();
                    }

                    $sub_iterator->offsetSet($sub_iterator->key(), $value);
                }
            }
        }

        return $recursive_iterator->getArrayCopy();

    }

    static function get_kategori_barang_fixed($kategori_search, $wilayah_avail = null){

        if($kategori_search == 'all'){

            $result = LokasiModel::get_custom_data_jumlah($wilayah_avail);


            $itemsByReference = array();

            foreach($result as $key => &$item) {
                $itemsByReference[$item['id']] = &$item;
                $itemsByReference[$item['id']]['children'] = array();

                $get_jumlah_barang = BarangModel::where('id_lokasi', $item['id'])->count();
                $get_nominal_barang = BarangModel::where('id_lokasi', $item['id'])->sum('harga_perolehan');

                $item['count'] = $get_jumlah_barang;
                $item['nominal'] = $get_nominal_barang;
            }

            foreach($result as $key => &$item){
                if($item['parent_id'] && isset($itemsByReference[$item['parent_id']]))
                    $itemsByReference [$item['parent_id']]['children'][] = &$item;
            }

            foreach($result as $key => &$item) {
                if($item['parent_id'] && isset($itemsByReference[$item['parent_id']]))
                    unset($result[$key]);
            }
            
            $data_push = [];
            foreach ($result as $row) {
                $data_push[] = $row;
            }

            $modified_tree = LaporanModel::modify_tree_barang_fixed($data_push);
            foreach ($modified_tree as $key => $value) {
                unset($modified_tree[$key]['children']);
            }


            return $modified_tree;

        }else{


            $result = LokasiModel::get_custom_data_jumlah_parent_only($wilayah_avail);

            $data_push = array();

            foreach ($result as $key => $row) {
                
                $get_chained_lokasi_tree = LokasiModel::get_custom_lokasi_parent($row['id']);
                
                $get_jumlah_barang = 0;
                $get_nominal_barang = 0;

                foreach($get_chained_lokasi_tree as $kk => $lokasi){

                    $reee = KategoriModel::get_custom_data_jumlah_by_parentID($kategori_search);

                    // print_r($reee);
                    // echo "<br/>";
                    // echo "<hr>";

                    foreach($reee as $kk2 => $kategori){

                        $get_jumlah_barang += BarangModel::where('id_lokasi', $lokasi['id'])->where('id_kategori', $kategori['id'])->count();
                        $get_nominal_barang += BarangModel::where('id_lokasi', $lokasi['id'])->where('id_kategori', $kategori['id'])->sum('harga_perolehan');

                    }

                }


                $data_push[] = array(
                    'id' => $row['id'],
                    'text' => $row['text'],
                    'parent_id' => $row['parent_id'],
                    'kode' => $row['kode'],
                    'count' => $get_jumlah_barang,
                    'nominal' => $get_nominal_barang,
                );

            }

            return $data_push;

            // $itemsByReference = array();

            // foreach($result as $key => &$item) {
            //     $itemsByReference[$item['id']] = &$item;
            //     $itemsByReference[$item['id']]['children'] = array();

                // $get_jumlah_barang = LaporanModel::get_tree_kategori($kategori_search, $item['id']);

            //     // print_r(LaporanModel::get_tree_kategori($kategori_search, $item['id']));

            //     // $get_jumlah_barang = 0;


                // $reee = KategoriModel::get_custom_data_jumlah_by_parentID($kategori_search);

                // // print_r($reee);
                // // echo "<br/>";

                // $jml = 0;
                // $nml = 0;

                // foreach($reee as $key => $val){

                //     $get_jumlah_barang = BarangModel::where('id_lokasi', $item['id'])->where('id_kategori', $val['id'])->count();
                //     $get_nominal_barang = BarangModel::where('id_lokasi', $item['id'])->where('id_kategori', $val['id'])->sum('harga_perolehan');
                //     // echo $item['text'].' ('.$item['id'].')'.' - '.$val['text'].' ('.$val['id'].')'.' : '.$get_jumlah_barang;
                //     // echo "<br/>";
                //     $jml += $get_jumlah_barang;
                //     $nml += $get_nominal_barang;

                // }

            //     $item['count'] = $jml;
            //     $item['nominal'] = $nml;
            // }

            // foreach($result as $key => &$item){
            //     if($item['parent_id'] && isset($itemsByReference[$item['parent_id']]))
            //         $itemsByReference [$item['parent_id']]['children'][] = &$item;
            // }

            // foreach($result as $key => &$item) {
            //     if($item['parent_id'] && isset($itemsByReference[$item['parent_id']]))
            //         unset($result[$key]);
            // }
            
            // $data_push = [];
            // foreach ($result as $row) {
            //     $data_push[] = $row;
            // }

            // $modified_tree = LaporanModel::modify_tree_barang_fixed($data_push);
            // foreach ($modified_tree as $key => $value) {
            //     unset($modified_tree[$key]['children']);
            // }


            // return $modified_tree;

        }

    }

    static function get_tree_kategori($kategori, $lokasi){

        $result = KategoriModel::get_custom_data_jumlah_by_parentID($kategori);

        $jml = 0;

        foreach($result as $key => $val){

            $get_jumlah_barang = BarangModel::where('id_lokasi', $lokasi)->where('id_kategori', $val['id'])->count();
            $jml += $get_jumlah_barang;

        }

        return $jml;
        // $itemsByReference = array();

        // foreach($result as $key => &$item) {
        //     $itemsByReference[$item['id']] = &$item;
        //     $itemsByReference[$item['id']]['children'] = array();

            // $get_jumlah_barang = BarangModel::where('id_lokasi', $lokasi)->where('id_kategori', $item['id'])->count();
            // $item['count'] = $get_jumlah_barang;

        // }

        // foreach($result as $key => &$item){
        //     if($item['parent_id'] && isset($itemsByReference[$item['parent_id']]))
        //         $itemsByReference [$item['parent_id']]['children'][] = &$item;
        // }

        // foreach($result as $key => &$item) {
        //     if($item['parent_id'] && isset($itemsByReference[$item['parent_id']]))
        //         unset($result[$key]);
        // }

        // $data_push = [];
        // foreach ($result as $row) {
        //     if($row['id'] == $kategori) $data_push[] = $row;
        // }

        // $modified_tree = LaporanModel::modify_tree_barang_fixed($data_push);
        // foreach ($modified_tree as $key => $value) {
        //     unset($modified_tree[$key]['children']);
        // }

        // return (isset($modified_tree[0]['count']) ? $modified_tree[0]['count'] : 0);

    }

}
