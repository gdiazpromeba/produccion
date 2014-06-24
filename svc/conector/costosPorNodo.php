<?php
  header("Content-Type: text/plain; charset=utf-8");

  $url=$_SERVER['PHP_SELF'];
   
  $arr=explode("/", $url);
  $ultimo=array_pop($arr);
  
  $node = $_REQUEST['node'];
  $piezaId = $_REQUEST['piezaId'];
  if ($node == 0){                  // < if it´s the first node
    $node = 1; // Initial node.
  }
  
  class AlimentaArbol{
 
	/*
	 * Load tree node.
	 */	
	 function getTree($TYPO3_db, $TYPO3_db_username, $TYPO3_db_password, $TYPO3_db_host, $node, $piezaId){
		$conn = mysql_connect($TYPO3_db_host, $TYPO3_db_username, $TYPO3_db_password); 
		mysql_select_db($TYPO3_db, $conn);
		$nodes = $this->display_children($node, $piezaId);
		mysql_close($conn);
		print json_encode($nodes);
	}
 
	// http://www.sitepoint.com/article/hierarchical-data-database
	// http://extjs.com/forum/archive/index.php/t-10082.html
	// $parent is the parent of the children we want to see
	// $level is increased when we go deeper into the tree,
	//        used to display a nice indented tree
 
	function display_children($parent, $piezaId) {
		// retrieve all children of $parent
		$result = mysql_query(  'SELECT COSTO_ITEM_ID, TEXTO_NODO, ORDEN ' .
								' FROM COSTOS ' .
								" WHERE " .
								"   PIEZA_ID ='". $piezaId . "'" .
								"   AND ITEM_PADRE ='" . $parent . "' " .
								' ORDER BY ORDEN;');

		// display each child
		while ($row = mysql_fetch_array($result)) {
			// Response parameters.
			$path['text']		= html_entity_decode($row['TEXTO_NODO']);
			$path['id']		= $row['COSTO_ITEM_ID'];
			$path['position']	= $row['ORDEN'];
			// Check if node is a leaf or a folder.
			$sql="SELECT COUNT(*) \n" .
			     "FROM COSTOS     \n" .
				 " WHERE " .
				 "   PIEZA_ID ='". $piezaId . "'" .
				 "   AND ITEM_PADRE='"  . $row['COSTO_ITEM_ID'] . "'" . 
				 ' ORDER BY ORDEN ';
			$resCuenta = mysql_query($sql);
            $total = mysql_fetch_array($resCuenta);
            $cCount = $total[0]; 
			if($cCount > 0){
				$path['leaf']	= false;
				//$path['cls']	= 'folder';
				$path['cls']	= 'nodo-proceso';
			}else{
				$path['leaf']	= true;
				$path['cls']	= 'file';
			}
 
			// call this function again to display this
			// child's children
			$nodes[] = $path;
		}
		return $nodes;
	}
 
 
}
$treeDataModel = new AlimentaArbol;
$treeDataModel ->getTree('kallisto_produccion','kallisto_gonzalo','manuela','localhost', $node, $piezaId);  
?>
