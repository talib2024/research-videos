<?php
namespace App\Http\ViewComposers;
use Illuminate\View\View;

class MajorCatogryViewComposer
{
    public function compose(View $view)
    {
        $majorCategory = major_category();
        $view->with('majorCategory_viewComposer', $majorCategory);
    }
}

?>