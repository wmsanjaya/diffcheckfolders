<?php
	echo "Starting diff check...\n<br>";
	$t0 = microtime(true);
	//define('BASE',"C:\\\\\\xampp\\\\\\htdocs\\\\\\");
	define('BASE',"C:/xampp/htdocs/");
	define('DS',DIRECTORY_SEPARATOR);
	define('BR', "<br/>");

	$dirs = array_filter(glob('*'), 'is_dir');
	
	if (!empty($_POST)) {		
		$original = BASE.$_POST['original'];		
		$website  = BASE.$_POST['website'];
		$output   = BASE.$_POST['original'].".report.diff.txt";
		$sortfile = BASE.$_POST['original'].".sort.txt";
		$editfile = BASE.$_POST['original'].".edited_files.txt";
		$diffresl = BASE.$_POST['original'].".diff_result.txt";
		
		if ($original && $original) {
			/* Diff Check */
			echo "Diff checking..\n<br>";			
			$command = 'diff -qrbB '.$original.' '.$website.'>'.$output ;
			$w_bash =  "C:\Program Files (x86)\Git\bin\sh.exe";
			$exec = "\"$w_bash\" --login -i -c \"$command\" 2>&1";									
			shell_exec($exec);
			/* Diff Check */
			
			/* Sort the report */
			echo "Sorting..\n<br>";
			$sortCommand = 'cat '.$output.' |sort > '.$sortfile;
			$sexec = "\"$w_bash\" --login -i -c \"$sortCommand\" 2>&1";
			shell_exec($sexec);
			/* Sort the report */
			
			/* Create edited files */
			echo "Generate Edited File..\n<br>";
			$editCommand = 'cat '.$sortfile.' |grep differ > '.$editfile;
			$sexec = "\"$w_bash\" --login -i -c \"$editCommand\" 2>&1";
			shell_exec($sexec);
			echo $editfile." Generated Edited File..\n<br>";
			/* Create edited files */
			
			/* Create edited files */
			echo "Generate Edited File..\n<br>";
			$editCommand = 'cat '.$sortfile.' |grep differ > '.$editfile;
			$sexec = "\"$w_bash\" --login -i -c \"$editCommand\" 2>&1";
			shell_exec($sexec);
			echo $editfile." Generated Edited File..\n<br>";
			/* Create edited files */
			
			/* Create report */
			echo "Create Report..\n<br>";
			$reportCommand = 'while read arg1 arg2 arg3 arg4 arg5 line; do git diff -w $arg2 $arg4 >> '.$diffresl.'; done < '.$editfile;
			$sexec = "\"$w_bash\" --login -i -c \"$reportCommand\" 2>&1";
			shell_exec($sexec);
			/* Create report */
						
		}						
		$t = round(microtime(true) - $t0,3)*1000;
		echo "<br>Done: $t ms";
	} else {	
		echo BASE;
	
		$optn = "";
		foreach ($dirs AS $dir) {
			$optn .= "<option  value='".$dir."'>".$dir."</option>";
		}
?>
		<form method="POST"  action="diffcheck.php">
		<?php
			echo BR;
			echo "Original Folder";
			echo BR;
			echo "<select name='original'>";
			echo $optn;
			echo "</select>";
			echo BR;
			echo "Website Folder";
			echo BR;
			echo "<select name='website'>";
			echo $optn;
			echo "</select>";
			echo "";
			echo BR;	
		?>
		<button type='submit' value="">Do the Diffcheck</button>
		</form>
	<?php } ?>
	
