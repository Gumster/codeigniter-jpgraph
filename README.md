# codeigniter-jpgraph
Hack to integrate JpGraph library into Codeigniter 2.x

Controller grapher.php has an example graph which shows basic 
configuration and use.

USE:

$this->load->library('JpGraph/Graph');

// If we want a bar graph, use JpGraph's bar chart library
require_once (APPPATH.'/libraries/JpGraph/jpgraph_bar.php');

$graph = new Graph(600, 350, 'auto');
...

