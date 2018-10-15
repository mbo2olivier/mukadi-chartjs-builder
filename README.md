Mukadi Chart Builder
====================

Generate beautiful and fully customised charts directly from SQL query. The `mukadi/chartjs-builder`library use [Chart.js](https://www.chartjs.org/) for displaying charts and [PDO](http://php.net/manual/fr/class.pdo.php) for querying data in your database.

## Installation

Run `php composer.phar require mukadi/chartjs-builder`

If your are not using composer for managing your dependencies (you should !), you can just downlaod library from the repo and include the library autoloader file in your code and all package classes will be available:

``` php
require 'path-to-the-library/autoload.php';
```
## Chart builder

The `Mukadi\Chart\Builder` is the main package class used for create chart from SQL query. This class require a valid PDO connection as constructor parameter:

``` php
use Mukadi\Chart\Builder;

$connection = new \PDO('mysql:dbname=test_jx;host=127.0.0.1','root','root');
$builder = new Builder($connection);
```
Once the `Builder` object instanciated, your can set the query from which you want your chart being generated

``` php
$builder->query('SELECT COUNT(*) total, AVG(prix) prix, console FROM jeux_video GROUP BY console')

# or with parameters
$builder
    ->query('SELECT COUNT(*) total, AVG(prix) prix, console FROM jeux_video WHERE possesseur = :possesseur GROUP BY console')
    ->setParameter(':possesseur',"Kapiamba")
```
## Labels and datasets

After the query configuration,  you can set chart datasets and labels (displayed in the x axis):

``` php
use Mukadi\Chart\Utils\RandomColorFactory;

$builder
    ...
    ->addDataset('total','Totals',[
        "backgroundColor" => RandomColorFactory::getRandomColors(12),
    ])
    ->addDataset('prix','Prix moyen',[
        "backgroundColor" => RandomColorFactory::getRandomColors(12),
    ])
    ->labels('console')

```

Setup datasets by specifying: the column where fetching data, a text that will be used as label for the dataset and optionally an array of options (see the [chart.js documentation](http://www.chartjs.org/docs/) for available options). For the chart labels just set the column where querying data or directly put an array of string.

## build and render chart

Last but not least, you have to build and render the chart in your view. For build your chart give an Id and set the chart type, optionally you can set some options (see the [chart.js documentation](http://www.chartjs.org/docs/)  for available options):

``` php
use Mukadi\Chart\Chart;

# Build the chart 
$chart = $builder->buildChart('game_stat_chart',Chart::BAR);

//then you can add or override the chart options. In this example you remove the onClick behavior of legend
$chart->pushOptions([
    'legend' => [
        'onClick' => null,
    ]
]);
```
For render the chart in your page juste make an echo:

``` php
echo $chart;

```

Don't forget to include libraries in your page:

``` html
<script src="assets/jquery.js"></script>
<script src="assets/Chart.bundle.min.js"></script>
<script src="assets/mukadi.chart.min.js"></script>

```
And that's all !