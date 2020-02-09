<?php
namespace App\Controller;

use App\App\Core\Response;
use App\App\Model\Ingredient;
use App\App\Model\Recipe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LunchController extends AbstractController
{
    /**
     * @Route("/lunch", name="lunch", methods={"GET"})
     */
    public function list(Request $request)
    {
        try {
            $useBy = $request->query->get('use-by', '');
            $bestBefore = $request->query->get('best-before', '');

            $recipe = new Recipe();
            $recipeList = $recipe->get();

            if(!empty($useBy) || !empty($bestBefore)) {

                $lessFreshList = [];
                foreach ($recipeList as $key => $item) {
                    foreach ($item["ingredients"] as $ingredientItem) {

                        if(!empty($useBy)) {
                            // Given that an ingredient is past its use-by date (inclusive),
                            // I should not receive recipes containing this ingredient
                            $ingredient = new Ingredient();
                            $ingredient->where("title", $ingredientItem);
                            if (!empty($ingredient->first()) && ($ingredient->first())["use-by"] < $useBy) {
                                unset($recipeList[$key]);
                                break;
                            }

                            if(!empty($bestBefore)) {
                                // Given that an ingredient is past its best-before date (inclusive),
                                // but is still within its use-by date (inclusive), any recipe containing
                                // the oldest (less fresh) ingredient should placed at the bottom of the response object
                                if (!empty($ingredient->first()) &&
                                    ($ingredient->first())["best-before"] < $bestBefore &&
                                    ($ingredient->first())["use-by"] >= $useBy
                                ) {
                                    $lessFreshList[] = $recipeList[$key];
                                    unset($recipeList[$key]);
                                    break;
                                }
                            }
                        }
                    }
                }

                // placed less fresh ingredient at the bottom
                $recipeList = array_merge($recipeList, $lessFreshList);
            }

            return Response::isOk($recipeList);
        } catch (\Exception $ex) {
            return Response::isFail($ex);
        }

    }
}