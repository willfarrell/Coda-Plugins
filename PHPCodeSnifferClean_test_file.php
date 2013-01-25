<?

/**
 * Automatically corrects small syntax error pointed out by code sniffer
 *
 * PHP Version 5
 *
 *  @category    N/A
 *  @package     Null
 * @author      will Farrell <will.farrell@gmail.com>
 * @copyright    2001 - 2011 willFarrell.ca
 *  @license     http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version        GIT: $Id$
 *  @link        http://pear.php.net/package/PackageName
 */

include('class.profile.php');   

$test = 'test';    

/**
 * Code_Sniffer_Clean
 * 
 *  @category   Null
 * @package     N/A
 *  @author     Original Author <author@example.com>
 * @author      Another Author <another@example.com>
 *  @copyright  2001 - 2011 willFarrell.ca
 *  @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   Release: @package_version@
 *  @link       http://pear.php.net/package/PackageName
 */

class Test_Class {
	
	/**
	 *	Print Users
	 *	
	 *	@param int $div - company_ID from companies table
	 *@return	string - all users for a company
	 *	@access	puiblic
	 */
	function ViewProfile($div = "") {
		$this->div = $div;
	}
	
	/**
	 *	Print Users
	 *	
	 *	@param	int $a - company_ID from companies table
	 *@param	object $bb - company_ID from companies table
	 *	@param	 bool $ccc - company_ID from companies table
	 *	@return	string - all users for a company
	 *	@access	puiblic
	 */
	
	function printUsers($a = TRUE, $bb = NULL, $ccc = FALSE) {
		$bb = "asdfg";   
		$bb = 'asdf';   
		
		if(1){
			$return = "No users found";
		}elseif(1){
			
		}else{
			$a = array(1,2,3,4);
			while(0){
				
			}
			$size = count($a);
			
			$size = sizeof($a);
			foreach($a as $d){
				?>
                <?='test'?>
                <? echo 'test'; ?>
                <?
			}
			foreach($a as $k => $v){
				?>
                <?='test'?>
                <? echo 'test'; ?>
                <?
			}
			for($i = 0; $i< 9995; $i++) {
				if($a == $b) {
					print 'do something';	
				}
			}
		}
		print $bb;
		return $return;
	}
	
}

$test =& new Test_Class;

?>