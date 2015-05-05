<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Grapher extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // load core JpGraph as CI library
        $this->load->library('JpGraph/Graph');
    }

    public function index() {
        
        // We want a bar graph, so use JpGraph's bar chart library
        require_once (APPPATH.'/libraries/JpGraph/jpgraph_bar.php');


        // Example data (04/2015)
        $json = '[{"Hogwarts Academy":{"Yield":"19021 kWh","Yield specific":"127.01 kWh\/kWp","Target yield":"16069.23 kWh","Current-target yield %":"<span style=\"color: #3ab121\">118.37 %<span>"}},{"cols": [{"id":"","label":"Time","pattern":"","type":"string"},{"id":"","label":"Hogwarts Academy (AC)","pattern":"","type":"number"},{"id":"","label":"Target values","pattern":"","type":"number"}], "rows": [{"c":[{"v":"01/04","f":null}, {"v":615.8,"f":"615,80 kWh"}, {"v":535.640966432,"f":"535,64 kWh"}]},{"c":[{"v":"02/04","f":null}, {"v":712.5,"f":"712,50 kWh"}, {"v":535.640966432,"f":"535,64 kWh"}]},{"c":[{"v":"03/04","f":null}, {"v":171,"f":"171,00 kWh"}, {"v":535.640966432,"f":"535,64 kWh"}]},{"c":[{"v":"04/04","f":null}, {"v":382.3,"f":"382,30 kWh"}, {"v":535.640966432,"f":"535,64 kWh"}]},{"c":[{"v":"05/04","f":null}, {"v":606.3,"f":"606,30 kWh"}, {"v":535.640966432,"f":"535,64 kWh"}]},{"c":[{"v":"06/04","f":null}, {"v":774.5,"f":"774,50 kWh"}, {"v":535.640966432,"f":"535,64 kWh"}]},{"c":[{"v":"07/04","f":null}, {"v":570.6,"f":"570,60 kWh"}, {"v":535.640966432,"f":"535,64 kWh"}]},{"c":[{"v":"08/04","f":null}, {"v":726.8,"f":"726,80 kWh"}, {"v":535.640966432,"f":"535,64 kWh"}]},{"c":[{"v":"09/04","f":null}, {"v":789.2,"f":"789,20 kWh"}, {"v":535.640966432,"f":"535,64 kWh"}]},{"c":[{"v":"10/04","f":null}, {"v":592.9,"f":"592,90 kWh"}, {"v":535.640966432,"f":"535,64 kWh"}]},{"c":[{"v":"11/04","f":null}, {"v":677.1,"f":"677,10 kWh"}, {"v":535.640966432,"f":"535,64 kWh"}]},{"c":[{"v":"12/04","f":null}, {"v":244.5,"f":"244,50 kWh"}, {"v":535.640966432,"f":"535,64 kWh"}]},{"c":[{"v":"13/04","f":null}, {"v":457.4,"f":"457,40 kWh"}, {"v":535.640966432,"f":"535,64 kWh"}]},{"c":[{"v":"14/04","f":null}, {"v":340.8,"f":"340,80 kWh"}, {"v":535.640966432,"f":"535,64 kWh"}]},{"c":[{"v":"15/04","f":null}, {"v":425.3,"f":"425,30 kWh"}, {"v":535.640966432,"f":"535,64 kWh"}]},{"c":[{"v":"16/04","f":null}, {"v":828.8,"f":"828,80 kWh"}, {"v":535.640966432,"f":"535,64 kWh"}]},{"c":[{"v":"17/04","f":null}, {"v":616.8,"f":"616,80 kWh"}, {"v":535.640966432,"f":"535,64 kWh"}]},{"c":[{"v":"18/04","f":null}, {"v":660.3,"f":"660,30 kWh"}, {"v":535.640966432,"f":"535,64 kWh"}]},{"c":[{"v":"19/04","f":null}, {"v":453.2,"f":"453,20 kWh"}, {"v":535.640966432,"f":"535,64 kWh"}]},{"c":[{"v":"20/04","f":null}, {"v":691.9,"f":"691,90 kWh"}, {"v":535.640966432,"f":"535,64 kWh"}]},{"c":[{"v":"21/04","f":null}, {"v":904.4,"f":"904,40 kWh"}, {"v":535.640966432,"f":"535,64 kWh"}]},{"c":[{"v":"22/04","f":null}, {"v":879.1,"f":"879,10 kWh"}, {"v":535.640966432,"f":"535,64 kWh"}]},{"c":[{"v":"23/04","f":null}, {"v":824.8,"f":"824,80 kWh"}, {"v":535.640966432,"f":"535,64 kWh"}]},{"c":[{"v":"24/04","f":null}, {"v":777.9,"f":"777,90 kWh"}, {"v":535.640966432,"f":"535,64 kWh"}]},{"c":[{"v":"25/04","f":null}, {"v":413.8,"f":"413,80 kWh"}, {"v":535.640966432,"f":"535,64 kWh"}]},{"c":[{"v":"26/04","f":null}, {"v":834.8,"f":"834,80 kWh"}, {"v":535.640966432,"f":"535,64 kWh"}]},{"c":[{"v":"27/04","f":null}, {"v":920.8,"f":"920,80 kWh"}, {"v":535.640966432,"f":"535,64 kWh"}]},{"c":[{"v":"28/04","f":null}, {"v":751,"f":"751,00 kWh"}, {"v":535.640966432,"f":"535,64 kWh"}]},{"c":[{"v":"29/04","f":null}, {"v":737.7,"f":"737,70 kWh"}, {"v":535.640966432,"f":"535,64 kWh"}]},{"c":[{"v":"30/04","f":null}, {"v":638.7,"f":"638,70 kWh"}, {"v":535.640966432,"f":"535,64 kWh"}]}]}]';

        // Turn string into object
        $obj = json_decode($json);

        // Stores for graph data
        $xdata = array();
        $ydata = array();

        // Get coords data from object
        $obj_data = $obj[1]->rows;
        $counter = 1;
        // Add it to each of our storage arrays
        foreach ($obj_data as $data) {
            // only plot when there is a kW value
            if (isset($data->c[1]->v)) {
                $xdata[] = $data->c[0]->v; // date
                $ydata[] = $data->c[1]->v; // kw
            }
        }

        // Create the graph. 
        // One minute timeout for the cached image
        // INLINE_NO means don't stream it back to the browser.
        $graph = new Graph(600, 350, 'auto');
        $graph->SetScale("textlin");
        $graph->img->SetMargin(60, 30, 20, 40);
        $graph->yaxis->SetTitleMargin(45);
        $graph->yaxis->scale->SetGrace(30);
        $graph->SetShadow();

        // Turn the tickmarks
        $graph->xaxis->SetTickSide(SIDE_DOWN);
        $graph->yaxis->SetTickSide(SIDE_LEFT);

        // Create a bar pot
        $bplot = new BarPlot($ydata);

        $bplot->SetFillColor("orange");

        // Use a shadow on the bar graphs (just use the default settings)
        $bplot->SetShadow();
        $bplot->value->SetFormat(" %2.1f kW", 70);
        $bplot->value->SetFont(FF_VERDANA, FS_NORMAL, 8);
        $bplot->value->SetColor("blue");
        $bplot->value->Show();

        $graph->Add($bplot);

        $graph->title->Set("Hogwarts Academy");
        $graph->xaxis->title->Set("Day");
        $graph->yaxis->title->Set("Yield in kilowatt hours");

        $graph->title->SetFont(FF_FONT1, FS_BOLD);
        $graph->yaxis->title->SetFont(FF_FONT1, FS_BOLD);
        $graph->xaxis->title->SetFont(FF_FONT1, FS_BOLD);

        // Send back the HTML page which will call this script again
        // to retrieve the image.
        $graph->StrokeCSIM();
    }

}

/* End of file grapher.php */
/* Location: ./application/controllers/grapher.php */