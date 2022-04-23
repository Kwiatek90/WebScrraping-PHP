<?php

function getEuroHTMLContent($url = 'https://www.euro.com.pl/laptopy-i-netbooki.bhtml'){ //funkcja majaca za zadanie pobranie danych ze strony euro i przetworzenie ich do stanu w ktorym beda sie nadawaly do wyswietlania na stronie
    $euroHTML = file_get_html($url); //pobranie danych ze strony euro

    $products = []; //deklarjemy pusta tablice produktow

    foreach($euroHTML->find('.product-box') as $product){ //przechodzimy petlo po wszystkich elemetach html ktora zwrocila funkcja
        $attribiutes = []; //pusta tablica w ktorej znajda sie poszczegone czesci opisu produktow

        if(!count($product->find('.product-name')) || !count($product->find('.product-photo .photo-hover')) || !count($product->find('.price-normal'))){
            continue; //sprawdzamy czy istnieje nazwa zdjecie i cena , jezeli nie istnieje ktorych z tych elementow to przechodzmy do kolejnej iteracji
        }

        $title = trim(preg_replace('/\s\s+/', ' ', $product->find('.product-name')[0]->plaintext)); //pobieramy tytul usuwamy z niego spacje przed i po 
        $image = 'https://www.euro.com.pl' . $product->find('.product-photo .photo-hover')[0]->{'data-hover'}; //pobieramy link do zdjecia prduktu
        $price = trim(preg_replace('/\s\s+/', ' ', $product->find('.price-normal')[0]->plaintext));//pobieramy cene i usuwamy spacje z pocztaku i konca

        foreach($product->find('.product-attributes .attributes-row') as $attribute){//iterujemy po poszczegolnych fragmentach opisu produktow 
            array_push($attribiutes, trim(preg_replace('/\s\s+/', ' ', $attribute->plaintext)));  //i wkladmy do tablicy i usuwamy biale znaki
        }

        $shopUrl = 'https://www.euro.com.pl' . $product->find('.product-name a')[0]->href; //pobieramy link do produkty
        //dodajemy do tablicy nowy obiekt
        array_push($products, new ScrapperItem($title, $image, $price, $attribiutes,  $shopUrl, 'https://f00.esfr.pl/img/desktop/euro/logo.png'));
    }


    return $products; //zwracamy cala tablce produktow
} 
function generateURLForEuroScrapping($params){ //funkcja ktora generuje adres url
    if(isset($_GET['shop']) && !in_array('euro', $_GET['shop'])){ //jesli w wyszukiwarce nie zostal wybrany sklep euro to funcja zwroci false
        return false;
    }

    $url = 'https://www.euro.com.pl/laptopy-i-netbooki';//bazowy adres wyszukiwarki

    //sprawdzamy czy w wyszukiwarce zostal wybrany producent jezeli tak to dadajemy go do linku z pozostalymi wartosciami tak samo czyli ram itd
    //https://www.euro.com.pl/laptopy-i-netbooki,_HP,przekatna-ekranu-cale-!-17,pamiec-ram_2!16-gb.bhtml
    if(isset($_GET['producent'])){
        $url .= (",_" . $_GET['producent']);
    }
    if(isset($_GET['screen'])){
        $url .= (",przekatna-ekranu-cale-!-". $_GET['screen']);
    }

    if(isset($_GET['ram'])){
         $url .= (",pamiec-ram_2!". $_GET['ram'].'-gb');
    }
    echo($url.'.bhtml');
    return $url.'.bhtml'; //zwracamy wygenerowany adres strony
}
