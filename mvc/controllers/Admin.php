<?php

class Admin extends Controller
{

    private  $bills;
    private  $cart;
    private  $categories;
    private  $comment;
    private  $products;
    private  $users;
    
    function __construct()
    {
        $this->users = $this->model('UserModel');
        $this->products = $this->model('ProductModel');
        $this->categories = $this->model('CategoryModel');
        $this->bills = $this->model('BillModel');
    }

    function index()
    {
        $countUser = count($this->users->getAll());
        $countCate = count($this->categories->getAllCl());
        $countPro = count($this->products->getAll());
        $countBill = count($this->bills->getAllBill());
        $sumBill = $this->bills->sumBill();
        $bestSellerAll = $this->bills->bestSellerAll();
        $top5BestSeller = $this->bills->top5BestSeller();
        $top5BestSellerNew = [];
        foreach($top5BestSeller as $item) {
            $item['favorites'] = $this->products->countFavoritePro($item['id_pro']);
            $soldArr = $this->products->soldPro($item['id_pro']);
            if($soldArr) {
                $item['sold'] = $soldArr['sold'];
            }  else $item['sold'] = 0;

            array_push($top5BestSellerNew, $item);
        }
        $top5Favorites = $this->bills->top5Favorites();
        $top5FavoritesNew = [];
        foreach($top5Favorites as $item) {
            $item['favorites'] = $this->products->countFavoritePro($item['id_pro']);
            $soldArr = $this->products->soldPro($item['id_pro']);
            if($soldArr) {
                $item['sold'] = $soldArr['sold'];
            }  else $item['sold'] = 0;

            array_push($top5FavoritesNew, $item);
        }

        // show_array($top5FavoritesNew);

        return $this->view('admin', [
            'title' => 'QUẢN LÝ',
            'page' => 'manager/list',
            'countUser' => $countUser,
            'countCate' => $countCate,
            'countPro' => $countPro,
            'countBill' => $countBill,
            'sumBill' => $sumBill,
            'bestSellerAll' => $bestSellerAll,
            'top5BestSellerNew' => $top5BestSellerNew,
            'top5FavoritesNew' => $top5FavoritesNew,
        ]);
    }

}
