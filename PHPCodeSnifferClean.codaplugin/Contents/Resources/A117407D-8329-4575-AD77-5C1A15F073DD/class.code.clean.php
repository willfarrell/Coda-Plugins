#!/usr/bin/php
<?php

/**
 * Automatically corrects small syntax error pointed out by code sniffer
 *
 * PHP version 5
 *
 * @category  N/A
 * @package   N/A
 * @author    will Farrell <will.farrell@gmail.com>
 * @copyright 2001 - 2011 willFarrell.ca
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version   GIT: <git_id>
 * @link      http://willfarrell.ca
 */

/*
To Do:
- Add smart file/class spacing like function
- move function only spacing into smart spacing loop.
- define(*****, _____) **** to all caps
- <?php
 }
 ?>

*/

//$root_folder = dirname(__FILE__) . DIRECTORY_SEPARATOR;

/**
 * Code_Sniffer_Clean
 *
 * @category  N/A
 * @package   N/A
 * @author    will Farrell <will.farrell@gmail.com>
 * @copyright 2001 - 2011 willFarrell.ca
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version   GIT: <git_id>
 * @link      http://willfarrell.ca
 */
class Code_Sniffer_Clean
{
	var $version = "0.0.1";
	var $extensions = array('php', 'inc');
	var $debug = false;
	var $not_nl_regex = " \t";

	/**
	 * Constructor
	 */
	function __construct()
	{

	}

	/**
	 * Destructor
	 */
	function __destruct()
	{

	}

	/**
	 * Clean Code Snippet Function
	 *
	 * @param string $data a snippet of php source code
	 *
	 * @return string the altered code snippet
	 */
	function clean($data)
	{
		/*
		preg_match_all($regex, $data, $matches);
		print_r($matches);
		*/

		/*
		 * clean code
		 */
		$data = preg_replace("/\r/", "", $data);

		/*
		 * replace all "<?" with <?php
		 * ERROR: Short PHP opening tag used; expected "<?php" but found "<?"
		 */
		$data = preg_replace("/([".$this->not_nl_regex."]*)<\?([^\S]+)/i", "$1<?php$2", $data);

		/*
		 * replace all <\?= with <?php echo
		 * ERROR: Short PHP opening tag used with echo; expected "<?php echo ..." but found "<?= ..."
		 */
		$data = preg_replace("/([{$this->not_nl_regex}]*)<\?=[\s]*(.*?)[;]?[\s]*\?>/i", "$1<?php echo $2; ?>", $data);

		/*
		 * replace all <?php \} ?>
		 * ERROR | Closing brace must be on a line by itself
		 */
		$data = preg_replace("/([{$this->not_nl_regex}]*)<\?php[\s]*}[\s]*\?>/i", "$1<?php\n$1}\n$1?>", $data);

		/*
		 * fix all code includes with proper format and change to require_once
		 * ERROR: "include_once ' is a statement not a function'; no parentheses are required
		 */
		$regex = "/(require_once|include_once|require|include)[\s]*[\(]?['\"]?(.*?)['\"]?[\)]?;/i";
		$replace = "$1 '$2';";
		$data = preg_replace($regex, $replace, $data, -1, $count);
		
		$regex = "/(require|include) [']?(.*?)[']?;/i";
		$replace = "$1_once '$2';";
		$data = preg_replace($regex, $replace, $data, -1, $count);
		
		/*
		 * fix all if, for, foreach, while, switch statements with proper formatting
		 * ERROR: Expected "if (...) {\n"; found "if (...) {\n"
		 */
		$regex = "/(if|for|foreach|while|switch)[\s]*\([\s]*(.*?)[\s]*\)[\s]*([^\(\)])/i";
		$replace = "$1 ($2) $3";
		$data = preg_replace($regex, $replace, $data, -1, $count);
		$regex = "/(if|for|foreach|while|switch)[\s]*\([\s]*(.*?)[\s]*\)[\s]*{/i";
		$replace = "$1 ($2) {";
		$data = preg_replace($regex, $replace, $data, -1, $count);

		/*
		 * fix all elseif statements with proper formatting
		 * ERROR: Expected "} else if (...) {\n"; found "} else if (...) {\n"
		 * ERROR: Space after opening parenthesis of function call prohibited
		 * ERROR: Space before closing parenthesis of function call prohibited
		 */
		$regex = "/}[\s]*(else if|elseif)[\s]*\([\s]*(.*?)[\s]*\)[\s]*([^\(\)])/i";
		$replace = "} $1 ($2) $3";
		$data = preg_replace($regex, $replace, $data, -1, $count);
		$regex = "/}[\s]*(else if|elseif)[\s]*\([\s]*(.*?)[\s]*\)[\s]*{/i";
		$replace = "} $1 ($2) {";
		$data = preg_replace($regex, $replace, $data, -1, $count);

		/*
		 * fix all else statements with proper formatting
		 * ERROR: Expected "} else {\n"; found "} else {\n"
		 */
		$regex = "/}[\s]*else[\s]*{/i";
		$replace = "} else {";
		$data = preg_replace($regex, $replace, $data, -1, $count);

		/*
		 * fix all class statements with proper formatting
		 * ERROR: Opening brace of a class must be on the line after the definition
		 */
		$regex = "/([{$this->not_nl_regex}]*)class[\s]*([\w\s]*?)[\s]*{/i";
		$replace = "$1class $2\n$1{";
		$data = preg_replace($regex, $replace, $data, -1, $count);

		/*
		 * fix all function statements with proper formatting
		 */
		$regex = "/([{$this->not_nl_regex}]*)(|public |public static |private |private static )function[{$this->not_nl_regex}]+([\w]*)[\s]*\([\s]*(.*?)[\s]*\)[\s]*([^\(\)])/i";
		$replace = "$1$2function $3($4)\n$1$5";
		$data = preg_replace($regex, $replace, $data, -1, $count);
		
		/*
		 * add space after comma (,) in function calls
		 * ERROR | No space found after comma in function call
		 */
		$regex = "/([^,\s]+)\,([^,\s]+)/i";
		$replace = "$1, $2";
		$data = preg_replace($regex, $replace, $data, -1, $count);
		$data = preg_replace($regex, $replace, $data, -1, $count);
		
		/*
		 * remove space after ( and before ) on function calls
		 * ERROR: Space after opening parenthesis of function call prohibited
		 * ERROR: Space before closing parenthesis of function call prohibited
		 */
		$regex = "/([\w]+)\([\s]*(.*)[\s]+\)/i";
		$replace = "$1($2)";
		$data = preg_replace($regex, $replace, $data, -1, $count);
		$regex = "/([\w]+)\([\s]+(.*)[\s]*\)/i";
		$replace = "$1($2)";
		$data = preg_replace($regex, $replace, $data, -1, $count);

		/*
		 * convert true, false and null to lowercase
		 * ERROR: true, false and null must be lowercase;
		 */
		$data = preg_replace("/(true|false|null)/e", "''.strtolower('\\1').''", $data);

		//-- Comments --//
		/*
		 * fix file/class comment block
		 * ERROR: @category tag comment indented incorrectly;
		 */
		$tags = array(
			'category' => 'category  ',
			'package' => 'package   ',
			'author' => 'author    ',
			'copyright' => 'copyright ',
			'license' => 'license   ',
			'version' => 'version   ',
			'link' => 'link      ',
			'see' => 'see       ',
			'since' => 'since     ',
		);
		$regex = "/\*[{$this->not_nl_regex}]*@(category|package|author|copyright|license|version|link)[\s]*([^\n]*)/ie";
		$replace = "'* @'.\$tags['\\1'].'\\2'";
		$data = preg_replace($regex, $replace, $data, -1, $count);

		/*
		 * clean up @return, @access, etc
		 */
		$regex = "/\*[{$this->not_nl_regex}]*@(return|throws|access|see|since|deprecated|param)[\s]*([^\n]*)/";
		$replace = "* @$1 $2";
		$data = preg_replace($regex, $replace, $data, -1, $count);

		/*
		 * fix @param
		 * param has certain formating that cannot be done in a single regex
		 * ERROR: The variable names for parameters - (1) and - (2) do not align
		 * ERROR: Missing comment for param "$arg" at position 1
		 */
		preg_match_all("/\/\*\*([\s\S]*?)\*\//", $data, $matches);

		foreach ($matches[0] as $comment) {
			$comment_update = $comment;
			$length = 0;
			preg_match_all(
				"/\* @param [{$this->not_nl_regex}]*([a-z]*)[{$this->not_nl_regex}]*(\\$[\w]*)[{$this->not_nl_regex}]*([^\n]*)/i",
				$comment,
				$params
			);

			$param_size = count($params[0]);
			$type_size = 0;
			$var_size = 0;
			for ($i=0; $i<$param_size; $i++) {
				$type_size = ($type_size > strlen($params[1][$i]))?$type_size:strlen($params[1][$i]);
				$var_size = ($var_size > strlen($params[2][$i]))?$var_size:strlen($params[2][$i]);

			}

			for ($i=0; $i<$param_size; $i++) {
				$type = str_pad($params[1][$i], $type_size);
				$var = str_pad($params[2][$i], $var_size);
				$tag_comment = ($params[3][$i]) ? $params[3][$i] : "__comment_missing__";
				$comment_update = str_replace($params[0][$i], "* @param $type $var ".$tag_comment, $comment_update);
			}
			$data = str_replace($comment, $comment_update, $data);
		}


		/*
		 * remove blank line after tag, for ordering
		 */
		$regex = "/\* @(param|return|throws|access|see|since|deprecated)([^\n]*)\n([{$this->not_nl_regex}]*)\*([{$this->not_nl_regex}]*)\n/";
		$replace = "* @$1$2\n";
		$data = preg_replace($regex, $replace, $data, -1, $count);

		/*
		 * order function tags by standards
		 * ERROR: Parameters must appear immediately after the comment
		 */

		$tags_top = array('param');
		$tags_bottom = array('return', 'throws', 'access', 'static', 'see', 'since', 'deprecated');
		$regex = "/"
				."([{$this->not_nl_regex}]*)\* @(return|throws|access|see|since|deprecated)([^\n]*)\n"
				."([{$this->not_nl_regex}]*)\* @(param)([^\n]*)/";
		$replace = "$4* @$5$6\n$1* @$2$3";

		$tag_count = count($tags);
		while (count($tags_bottom)) {
			$regex = "/"
					."([{$this->not_nl_regex}]*)\* @(".implode('|', $tags_bottom).")([^\n]*)\n"
					."([{$this->not_nl_regex}]*)\* @(".implode('|', $tags_top).")([^\n]*)/";
			// continue till all tags have moved down
			$old_data = '';
			while ($data != $old_data) {
				$old_data = $data;
				$data = preg_replace($regex, $replace, $data, -1, $count);
			}
			$tags_top[] = array_shift($tags_bottom);
		}

		/*
		 * fix @param
		 * ERROR: Last parameter comment requires a blank newline after it
		 */
		$regex = "/\* @param ([^\n]*)\n([{$this->not_nl_regex}]*)\* @(return|throws|access|see|since|deprecated)/";
		$replace = "* @param $1\n$2* \n$2* @$3";
		$data = preg_replace($regex, $replace, $data, -1, $count);



		//-- Spacing --//
		/*
		 * replace all tabs with 4 spaces
		 * ERROR: Line indented incorrectly;
		 */
		//$data = preg_replace("/\t/", "    ", $data);

		/*
		 * remove trailing spaces
		 */
		$data = preg_replace("/[{$this->not_nl_regex}]+\n/", "\n", $data);

		return $data;
	}

	/**
	 * Clean all files ina  directory
	 *
	 * @param string $path a directory path
	 *
	 * @return null
	 */
	function cleanDir($path)
	{
		$fp = opendir($path);
		while ($f = readdir($fp)) {
			// ignore symbolic links
			if (preg_match("#^\.+$#", $f)) {
				continue;
			}
			$file_full_path = $path."/".$f;
			$path_parts = pathinfo($f);

			$data = file_get_contents($file_full_path);

			if (is_dir($file_full_path)) {
				/*
				 * Is a directory, call recursion
				 */
				$this->cleanDir($file_full_path);
			} else if (in_array($path_parts['extension'], $this->extensions)) {
				/*
				 * Is a valid file type, clean and save
				 */
				$data = $this->clean($data);
				$this->save($file_full_path, $data);
			} else {
				/*
				 * NOT a valid file type
				 */
			}
		}
	}

	/**
	 * save a file
	 *
	 * @param string $file file name with path
	 * @param string $data file contents to be saved
	 *
	 * @return null
	 */
	function save($file, $data)
	{
		$fh = fopen($file, 'w') or print("can't open file");
		fwrite($fh, $data);
		fclose($fh);
	}

}

$input = "";

$fp = fopen("php://stdin", "r");
while ($line = fgets($fp, 1024)) $input .= $line;




$clean = new Code_Sniffer_Clean;
$data = $clean->clean($input);
echo $data;

fclose($fp);

?>