Mukadi Chart Builder
====================

Generate beautiful and fully customised charts directly from SQL query. The `mukadi/chartjs-builder` library use [Chart.js](https://www.chartjs.org/) for displaying charts and [PDO](http://php.net/manual/fr/class.pdo.php) for querying data in your database.

## 1. Installation

Run `php composer.phar require mukadi/chartjs-builder`

If your are not using composer for managing your dependencies (you should !), you can just downlaod library from the repo and include the library autoloader file in your code and all package classes will be available:

``` php
require 'path-to-the-library/autoload.php';
```
## 2. The Factory

The `Mukadi\Chart\Factory\ChartFactory` is the main package class used for create chart from SQL query. This class require a valid PDO connection as constructor parameter:

``` php
use Mukadi\Chart\Factory\ChartFactory;

$connection = new \PDO('sqlite:/Users/foo/Projects/bar.db');
$factory = new ChartFactory($connection);
```

### 2.1. Chart Types
Once the `Factory` object instanciated, you can start building your chart. First thing to do is to specify the type of the chart you want, supported types are :

- Bar
- Pie
- Polar area
- Line
- Doughnut and
- Radar

``` php
$chart = $factory
    ->createChartBuilder()
    ->asBar() // asPie(), asPolarArea(), asLine() etc...
    ...
```

### 2.2. Query
Once the `Factory` object instanciated, your can set the query from which you want your chart being generated

``` php
$chart = $factory
    ->createChartBuilder()
    ->asBar()
        ->query('SELECT COUNT(*) total, AVG(prix) prix, console FROM jeux_video GROUP BY console') // SQL query
```
### 2.3. Labels
After the query configuration,  you can set chart labels (displayed in the x axis):

``` php
$chart = $factory
    ->createChartBuilder()
    ->asBar()
        ->query('SELECT COUNT(*) total, AVG(prix) prix, console FROM jeux_video GROUP BY console') // SQL query
    ->labels('console') // mapped to the console column
    
    # or you can provide array of predefined values
    ->labels(['NES', 'Game Cube', 'PSOne'])

    # you can also apply transformation to the labels before been displayed on the chart
    ->labels('console',  fn($c) => strtoupper($c)) // transform all console name to uppercase
```
### 2.4. Datasets

``` php
$chart = $factory
    ->createChartBuilder()
    ->asBar()
        ->query('SELECT COUNT(*) total, AVG(prix) prix, console FROM jeux_video GROUP BY console')
        ->labels('console')
        ->dataset("Total") # dataset labels
            ->data('total') # dataset mapped to the "total" column
            ->options([
                'backgroundColor' => RandomColorFactory::randomRGBColor()
            ])
        ->end()
        # you can add many datasets as you want
        ->dataset("Prix moyen")
            ->data('prix')
            ->useRandomBackgroundColor() # dataset color helper
        ->end()
    # build and return the chart
    ->build()
    ->getChart()
    ;

```

Setup datasets by specifying: the column where fetching data, a text that will be used as label for the dataset and optionally an array of options (see the [chart.js documentation](http://www.chartjs.org/docs/) for available options). For the chart labels just set the column where querying data or directly put an array of string.

### 2.5. Dataset helpers

*helper* | *description*
--- | --- 
useRandomBackgroundColor(bool $alpha = true) | use a different random background color (if is alpha is true a RGBA color will be used) for each dataset value
useRandomBorderColor(bool $alpha = true) | use a different random border color (if is alpha is true a RGBA color will be used) for each dataset value
useRandomHoverBackgroundColor(bool $alpha = true) | use a different random hover background color (if is alpha is true a RGBA color will be used) for each dataset value
useRandomHoverBackgroundColor(bool $alpha = true) | use a different random hover background color (if is alpha is true a RGBA color will be used) for each dataset value
useRandomHoverBorderColor(bool $alpha = true) | use a different random hover border color (if is alpha is true a RGBA color will be used) for each dataset value
### 2.6. Build and render chart

Last but not least, you have to build and render the chart in your view. For build your chart give an Id and set the chart type, optionally you can set some options (see the [chart.js documentation](http://www.chartjs.org/docs/)  for available options):

``` php

# Build the chart 
$chart = $factory
    ->createChartBuilder()
    ...
    ->build()
    ->getChart()
    # or you can pass chart options like this
    ->getChart([
        'scales' => [
            'x' => [
                'grid' => ['offset' => true]
            ],
        ]
    ])
;

//You can also add or override the chart options after being built. In this example you remove the onClick behavior of legend
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.2.1/chart.umd.min.js"></script>
<script src="dist/mukadi.chart.min.js"></script>

```
And that's all !

## 3. Advanced Topics

### 3.1. Use parametrized query
``` php
use Mukadi\Chart\Factory\ChartFactory;

$connection = new \PDO('sqlite:/Users/foo/Projects/bar.db');
$factory = new ChartFactory($connection);

$chart = $factory
    ->createChartBuilder()
    ->asBar()
    ->query('SELECT COUNT(*) total, AVG(prix) prix, console FROM jeux_video WHERE possesseur = :possesseur GROUP BY console') # prepared statement
        ->labels('console')
        ->dataset("Total")
            ->data('total')->useRandomBackgroundColor()
        ->end()
        ->dataset("Prix moyen")
            ->data('prix')->useRandomBackgroundColor()
        ->end()
    ->build()
    # setting the parameters after the build() method invokation
    ->setParameter(':possesseur',"Kapiamba") 
    ->getChart()

```

### 3.2. Charts Definition

When building charts we can quickly end up with many lines of code that pollute our controller/page (especially if it is a dashboard for example). The Charts definition is an elegant way to build your charts in separate classes, so you get a more readable code and also reusable charts (a very powerful feature when combining with parametrized query).

Every Charts definition must implements the `Mukadi\Chart\ChartDefinitionBuilderInterface` interface (of course ! :-D )

``` php
use Mukadi\Chart\ChartDefinitionBuilderInterface;

class VideoGame implements ChartDefinitionInterface {
    
    public function define(ChartDefinitionBuilderInterface $builder): void
    {
        $sql = "SELECT COUNT(*) total, AVG(prix) prix, console FROM jeux_video WHERE possesseur = :possesseur GROUP BY console";

        $builder
            ->asPolarArea()
            ->query($sql)
            ->labels('console')
            ->dataset("Total")
                ->data('total')->useRandomBackgroundColor()
            ->end()
            ->dataset("Prix moyen")
                ->data('prix')->useRandomBackgroundColor()
            ->end()
        ;
    }
}

```

In your controller/page you only have to write this:
``` php
...
$chart = $factory
            ->createFromDefinition(new VideoGame())
            ->setParameter(':possesseur', 'Florent')
            ->getChart()
        ;

# you can reuse the same definition for another owner just like this
$chart2 = $factory
            ->createFromDefinition(VideoGame::class) # you can also use the FQCN instead of an instance
            ->setParameter(':possesseur', 'Michel') # different parameter value
            ->getChart()
        ;

```

### 3.3. Custom Definition Provider

Internally, the `Mukadi\Chart\Factory\ChartFactory` class use a `Mukadi\Chart\DefinitionProviderInterface` implementation to retrieve a chart definition by it's FCQN (fully qualified class name), but this implementation is very simple and work only with no-args constructor Chart definition class. So if you defintion class has some dependencies we must build it by yourself and provide the instance to the factory.

There are some case where it's complex to build a definition instance by yourself or when you delegate this task to an external component such a DI container for example. In this case you may want the factory relying on the same component to build the chart definition for you.

First, Implement the `Mukadi\Chart\DefinitionProviderInterface` interface :

``` php
use Mukadi\Chart\ChartDefinitionInterface;
use Mukadi\Chart\DefinitionProviderInterface;

class MyCustomDefinitionProvider implements DefinitionProviderInterface {

    public function provide(string $fcqn): ChartDefinitionInterface
    {
        # implements your log here and return the instance

        return new $theChartDefinitionInstance;
    }
}
```

And secondly override the default one:

``` php
$connection = new \PDO('sqlite:/Users/foo/Projects/bar.db');
$factory = (new ChartFactory($connection))->overrideDefinitionProvider($myCustomProviderInstance);

```

You may also want to include the all factory in your DI strategy, to do so just implement you own factory by implementing the `Mukadi\Chart\ChartFactoryInterface` or by extending the `Mukadi\Chart\Factory\AbstractChartFactory`, you can refer to the [MukadiChartJsBundle](https://github.com/mbo2olivier/MukadiChartJSBundle) which is an integration of the current library for the Symfony Framework.