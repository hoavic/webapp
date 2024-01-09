@isset($breadcrumbs)

        @php
            $json =  (string)json_encode($breadcrumbs->breadcrumbs);

            $replaced = str_replace('"type"', '"@type"', $json);

            $replaced = str_replace('"context"', '"@context"', $json);
            echo '<script type="application/ld+json">'.$replaced.'</script>';
        @endphp

@endisset
