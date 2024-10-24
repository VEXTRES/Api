<?php

namespace App\Http\Controllers;

use App\Services\FatSecretService;
use Illuminate\Http\Request;

class FatSecretController extends Controller
{
    public function recipes(Request $request)
    {
        $search = $request->search ?? '';

        $fatSecret = new FatSecretService();

        $recipes = $fatSecret->getRecipes($search);

        foreach ($recipes['recipe'] as $recipe) {
            echo $recipe['recipe_name'] . '<br>';
        }
    }

    public function foods(Request $request) {
        $search = $request->search ?? '';

        $fatSecret = new FatSecretService();

        $foods = $fatSecret->getFoods($search);

        if (isset($foods['results']['food'])) {
            foreach ($foods['results']['food'] as $food) {
                // Mostrar el nombre del alimento
                echo $food['food_name'] . '<br>';

                if(isset($food['servings']['serving']['calories'])) {
                    echo 'Calorías: ' . $food['servings']['serving']['calories'] . '<br>';
                }

                if (isset($food['servings']['serving']['protein'])) {
                    echo 'Proteína: ' . $food['servings']['serving']['protein'] . '<br>';
                } else {
                    echo 'No hay información de proteínas para este alimento.<br>';
                }
            }
        } else {
            echo "No se encontraron alimentos.";
        }


    }
}
