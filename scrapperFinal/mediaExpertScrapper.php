<?php

function getMediaExpertHTMLContent($url = 'https://www.morele.net/kategoria/laptopy-31/'){ //funkcja majaca za zadanie pobranie danych ze strony euro i przetworzenie ich do stanu w ktorym beda sie nadawaly do wyswietlania na stronie
    $euroHTML = file_get_html($url); //pobranie danych ze strony euro

    $products = [];

    foreach($euroHTML->find('.cat-product-inside') as $product){
        $attribiutes = [];

        $title = trim(preg_replace('/\s\s+/', ' ', $product->find('.cat-product-name')[0]->plaintext));
        if(isset($product->find('.product-image')[0])){
            if($product->find('.product-image')[0]->src){
                $image = $product->find('.product-image')[0]->src;
            }
            elseif ($product->find('.product-image')[0]->getAttribute('data-src')){
                $image = $product->find('.product-image')[0]->getAttribute('data-src');
            }
            else{
                $image = 'https://evopc.pl/wp-content/plugins/woocommerce/assets/images/placeholder.png';
            }
        }
        else{
            $image = 'https://evopc.pl/wp-content/plugins/woocommerce/assets/images/placeholder.png';
        }

        if($product->find('.price-new')){
            $price = trim(preg_replace('/\s\s+/', ' ', $product->find('.price-new')[0]->plaintext)) . ' zł';
        }
        else{
            $price = 'Brak danych';
        }
       

        foreach($product->find('.cat-product-features') as $attribute){
            array_push($attribiutes, trim(preg_replace('/\s\s+/', ' ', $attribute->plaintext)));  
        }

        $shopUrl = 'https://www.morele.net' . $product->find('.productLink')[0]->href;

        array_push($products, new ScrapperItem($title, $image, $price, $attribiutes, $shopUrl, 'https://www.morele.net/static/img/shop/logo/image-logo-morele.svg'));
    }
    return $products;
}
function generateURLForMediaExpertScrapping($params){
    if(isset($_GET['shop']) && !in_array('media', $_GET['shop'])){
        return false;
    }

    $url = 'https://www.morele.net/kategoria/laptopy-31/';
    $ilosc=0;
    if(isset($_GET['producent'])){
        $wartosc=$_GET['producent'];
        if($wartosc==='hp'){
            $url .=  ",,,,,92,,,0,,,,";
        }
        if($wartosc==='lenovo'){
            $url .=  ",,,,,511,,,0,,,,";
        }
        if($wartosc==='acer'){
            $url .=  ",,,,,7,,,0,,,,";
        }
        if($wartosc==='dell'){
            $url .= ",,,,,248,,,0,,,,";
        }
        if($wartosc==='Apple'){
            $url .=  ",,,,,496,,,0,,,,";
        }
        $ilosc++;
    }
    if($ilosc==0){
        $url.=',,,,,,,,0,,,,';
    }
    if(isset($_GET['screen'])){
        $wartosc=$_GET['screen'];
        if($wartosc==='10'){
            $url .= "18749O477015.1692896.1678651";
        }
        if($wartosc==='11'){
            $url .= ",,,,,92,,,0,,,,18749O613598";
        }
        if($wartosc==='12'){
            $url .= "18749O1017253.1745528.1172698.890445";
        }
        if($wartosc==='13'){
            $url .= "18749O888064.322753.1652928";
        }
        if($wartosc==='14'){
            $url .= "18749O314031.977959.1893826.313129.1794655";
        }
        if($wartosc==='15'){
            $url .= "18749O314226.305602.406608.406774";
        }
        if($wartosc==='16'){
            $url .= "18749O1660281.1602601.1893740";
        }
        if($wartosc==='17'){
            $url .= "18749O1648611.321374";
        }
        if($wartosc==='18'){
            $url .= "18749O313926";
        }
    }
    $ilosc++;
    if(isset($_GET['ram'])){
        $wartosc=$_GET['ram'];
        if($wartosc==='2'){
            $url .= ",18755O613601";
        }
        if($wartosc==='4'){
            $url .= ",18755O888074";
        }
        if($wartosc==='8'){
            $url .= ",18755O367587";
        }
        if($wartosc==='16'){
            $url .= ",18755O894471";
        }
        if($wartosc==='32'){
            $url .= ",18755O957923.1126497";
        }
        $ilosc++;
    }

    

    echo($url).'/1/?noi';
    return $url.'/1/?noi';
}
