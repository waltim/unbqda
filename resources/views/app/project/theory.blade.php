<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/vis.min.css') }}">
</head>

<body>
    <div id="grafo" style="width: 100%; height: 800px;">

    </div>
</body>
<script type="text/javascript" src="{{ asset('js/vis.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/vis-network.min.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"
integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>


<script>

    var codesData = [];
    var codeCategoriesData = [];

    async function plotTheory() {

        var codesGet = await $.getJSON( "/theory_codes", function() {
        })
        .done(function(codes) {
            $.each(JSON.parse(codes), function (key, item) {
                //console.log(item);

                let code = {};
                code['id'] = item.id;
                code['label'] = item.description;
                //code['color'] = item.color;
                code['group'] = "nodes";

                codesData.push(code);
            });
            // console.log( "second success" );
            console.log(codesData);
        })
        .fail(function() {
            console.log( "error" );
        });

        var categoryGet = await $.getJSON( "/theory_categories", function() {
        })
        .done(function(categories) {
            $.each(JSON.parse(categories), function (key, item) {
                //console.log(item);

                let category = {};
                category['id'] = item.id + 1000;
                category['label'] = item.description;
                //category['color'] = item.color;
                if(item.category_id != null){
                    category['group'] = "categories";
                }else{
                    category['group'] = "subcategories";
                }
                codesData.push(category);
            });
            // console.log( "second success" );
            console.log(codesData);
        })
        .fail(function() {
            console.log( "error" );
        });


        var codeCategoryGet = await $.getJSON( "/theory_codeCategories", function() {
        })
        .done(function(codecategories) {
            $.each(JSON.parse(codecategories), function (key, item) {
                //console.log(item);

                let codecat = {};
                codecat['from'] = item.code_id;
                codecat['to'] = item.category_id + 1000;

                codeCategoriesData.push(codecat);
            });
            // console.log( "second success" );
            console.log(codeCategoriesData);
        })
        .fail(function() {
            console.log( "error" );
        });

        var subCategoryGet = await $.getJSON( "/theory_categories", function() {
        })
        .done(function(subcat) {
            $.each(JSON.parse(subcat), function (key, item) {
                //console.log(item);
                if(item.category_id != null){
                let subcategory = {};
                subcategory['from'] = item.id + 1000;
                subcategory['to'] = item.category_id + 1000;
                codeCategoriesData.push(subcategory);
                }
            });
            // console.log( "second success" );
            console.log(codeCategoriesData);
        })
        .fail(function() {
            console.log( "error" );
        });

        var nodes = new vis.DataSet(codesData);
        var edges = new vis.DataSet(codeCategoriesData);

        var container = document.getElementById("grafo");

        var dates = {
        nodes: nodes,
        edges: edges
        };

        var options = {
        groups: {
            categories: {color:{background:'#DCDCDC'}, borderWidth:3},
            nodes: {color:{background:'#add8e6'}, borderWidth:3},
            subcategories: {color:{background:'#90ee90'}, borderWidth:3},
        }

        }
        var graph = new vis.Network(container, dates, options);
    }

    plotTheory();
</script>

</html>
