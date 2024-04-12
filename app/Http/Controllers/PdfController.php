<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use PDF;



class PdfController extends Controller
{
    public function generatePDF($recipeId)
    {
        // レシピを取得
        $recipe = Recipe::find($recipeId);

        // PDFに表示するデータやビューを設定
        $data = [
            'recipe' => $recipe,
        ];

        // PDFを生成
        $pdf = PDF::loadView('pdf.recipe', $data);

        // 例: publicディレクトリ内のpdfディレクトリに保存する場合
        $pdf->save(public_path('pdf/recipe.pdf'));


        // error_log('Debug: Font path - ' . public_path('fonts/Meiryo.ttf'));

        // PDFをダウンロードまたは表示
        return $pdf->download('recipe.pdf');
    }


    
}
