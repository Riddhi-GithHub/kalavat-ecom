<?php
namespace App\Imports;

use App\Models\Product;

use Maatwebsite\Excel\Concerns\ToModel;
 use Maatwebsite\Excel\Concerns\Importable;
 use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
 use Importable;

    public function model(array $row)
    {
        return new Product([

            // 'product_name'              => $row[0],

            'cat_id'               =>   $row['cat_id'],
            'sub_cat_id'           =>   $row['sub_cat_id'],
            'sale_id'              =>   $row['sale_id'],
            'product_name'         =>   $row['product_name'],
            'img'                  =>   $row['img'],
            'description'          =>   $row['description'],
            'price'                =>   $row['price'],
            'quantity'             =>   $row['quantity'],
            'offer'                =>   $row['offer'],
            'colorrr'              =>   $row['colorrr'],
            'sizess'               =>   $row['sizess'],
            'branddd'              =>   $row['branddd'],
            'sort_desc'            =>   $row['sort_desc'],
            'size_and_fit'         =>   $row['size_and_fit'],
            'material_and_care'    =>   $row['material_and_care'],
            'style_note'           =>   $row['style_note'],
            'item_model_num'       =>   $row['item_model_num']
            
            
            
            
            
            

           
            
            

            // 'password' => \Hash::make('123456'),

        ]);

    }

}

?>