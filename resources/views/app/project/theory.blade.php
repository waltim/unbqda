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


<script>
    var nodes = new vis.DataSet([
        {
            id: 1,
            label: "A",
            color: "#D2E5FF"
        },
        {
            id: 10002,
            label: "B",
            color: '#F0F0F0'
        },
        {
            id: 3,
            label: "C",
            group: "nodes"
        },
        {
            id: 4,
            label: "D",
            group: "nodes"
        },
        {
            id: 5,
            label: "E",
            group: "nodes"
        }
    ]);

    var edges = new vis.DataSet([{
            from: 1,
            to: 10002
        },
        {
            from: 3,
            to: 10002
        },
        {
            from: 5,
            to: 10002
        },
        {
            from: 4,
            to: 10002
        }
    ]);

    var container = document.getElementById("grafo");

    var dates = {
        nodes: nodes,
        edges: edges
    };

    var options = {
        groups: {
            categories: {color:{background:'#D2E5FF'}, borderWidth:3},
            nodes: {color:{background:'blue'}, borderWidth:3}
        }

    }
    var graph = new vis.Network(container, dates, options);
</script>

</html>
