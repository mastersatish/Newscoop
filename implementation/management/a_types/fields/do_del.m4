B_HTML
INCLUDE_PHP_LIB(<*../..*>)
B_DATABASE

CHECK_BASIC_ACCESS
CHECK_ACCESS(<*DeleteArticleTypes*>)

B_HEAD
	X_EXPIRES
	X_TITLE(<*Deleting field*>)
	<?php  if ($access == 0) { ?>
		X_AD(<*You do not have the right to delete article type fields.*>)
	<?php  } ?>
E_HEAD

<?php  if ($access) { ?>dnl
B_STYLE
E_STYLE

B_BODY
<?php  todef('AType');
todef('Field');
    ?>dnl

B_HEADER(<*Deleting field*>)
B_HEADER_BUTTONS
X_HBUTTON(<*Fields*>, <*a_types/fields/?AType=<?php  print encURL($AType); ?>*>)
X_HBUTTON(<*Article Types*>, <*a_types/*>)
X_HBUTTON(<*Home*>, <*home.php*>)
X_HBUTTON(<*Logout*>, <*logout.php*>)
E_HEADER_BUTTONS
E_HEADER

B_CURRENT
X_CURRENT(<*Article type*>, <*<B><?php  print encHTML($AType); ?></B>*>)
E_CURRENT

<P>
<?php 
    query ("SHOW COLUMNS FROM X$AType LIKE 'F$Field'", 'c');
	if ($NUM_ROWS) {
		query ("ALTER TABLE X$AType DROP COLUMN F$Field");
		$params = array($operation_attr=>$operation_modify, "article_type"=>"$AType");
		$msg = build_reset_cache_msg($cache_type_article_types, $params);
		send_message($SERVER_ADDRESS, server_port(), $msg, $err_msg);
	}
?>dnl
B_MSGBOX(<*Deleting field*>)
	X_MSGBOX_TEXT(<*<LI><?php  putGS('The field $1 has been deleted.','<B>'.encHTML($Field).'</B>' ); ?></LI>*>)
X_AUDIT(<*72*>, <*getGS('Article type field $1 deleted',encHTML($Field))*>)
	B_MSGBOX_BUTTONS
		REDIRECT(<*Done*>, <*Done*>, <*X_ROOT/a_types/fields/?AType=<?php  print encURL($AType); ?>*>)
	E_MSGBOX_BUTTONS
E_MSGBOX
<P>

X_HR
X_COPYRIGHT
E_BODY
<?php  } ?>dnl

E_DATABASE
E_HTML
