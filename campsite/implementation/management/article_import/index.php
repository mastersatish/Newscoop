<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/classes/common.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/classes/Input.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/classes/Article.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/classes/Section.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/classes/Issue.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/classes/Publication.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/classes/Language.php');

$rootDirectory = $ADMIN_DIR;

list($access, $User) = check_basic_access($_REQUEST);
if (!$access) {
	header("Location: /$ADMIN/logout.php");
	exit;
}

$Pub = Input::Get('Pub', 'int', 0);
$Issue = Input::Get('Issue', 'int', 0);
$Section = Input::Get('Section', 'int', 0);
$Language = Input::Get('Language', 'int', 0);
$sLanguage = Input::Get('sLanguage', 'int', 0);
$Article = Input::Get('Article', 'int', 0);

if (!Input::IsValid()) {
	header("Location: /$ADMIN/logout.php");
	exit;
}

$articleObj =& new Article($Pub, $Issue, $Section, $sLanguage, $Article);
$sectionObj =& new Section($Pub, $Issue, $Language, $Section);
$issueObj =& new Issue($Pub, $Language, $Issue);
$publicationObj =& new Publication($Pub);
$articleLanguage =& new Language($Language);
$issueLanguage =& new Language($sLanguage);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<HTML>
<HEAD>
    <META http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script type="text/javascript" src="/javascript/fValidate/fValidate.config.js"></script>
    <script type="text/javascript" src="/javascript/fValidate/fValidate.core.js"></script>
    <script type="text/javascript" src="/javascript/fValidate/fValidate.lang-enUS.js"></script>
    <script type="text/javascript" src="/javascript/fValidate/fValidate.validators.js"></script>
	<TITLE><?php putGS("Article Import"); ?></TITLE>
	<LINK rel="stylesheet" type="text/css" href="/css/admin_stylesheet.css">
</HEAD>

<BODY>
<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="1" WIDTH="100%" class="page_title_container">
<TR>
	<TD class="page_title">
	    <?php putGS("Article Import"); ?>
	</TD>
	<TD ALIGN=RIGHT>
		<TABLE BORDER="0" CELLSPACING="1" CELLPADDING="0">
		<TR>
			<TD>
				<A HREF="/<?php echo $ADMIN; ?>/pub/issues/sections/articles/?Pub=<?php p($Pub); ?>&Issue=<?php p($Issue); ?>&Language=<?php p($Language); ?>&Section=<?php p($Section); ?>" class="breadcrumb">
				<?php putGS("Articles");  ?></A>
			</TD>
			<td class="breadcrumb_separator">&nbsp;</td>
			<TD>
				<A HREF="/<?php echo $ADMIN; ?>/pub/issues/sections/?Pub=<?php p($Pub); ?>&Issue=<?php p($Issue); ?>&Language=<?php p($Language); ?>" class="breadcrumb" ><?php putGS("Sections");  ?></A>
			</TD>
			<td class="breadcrumb_separator">&nbsp;</td>
			<TD>
				<A HREF="/<?php echo $ADMIN; ?>/pub/issues/?Pub=<?php p($Pub); ?>" class="breadcrumb" ><?php putGS("Issues");  ?></A>
			</TD>
			<td class="breadcrumb_separator">&nbsp;</td>
			<TD>
				<A HREF="/<?php echo $ADMIN; ?>/pub/" class="breadcrumb"><?php putGS("Publications");  ?></A>
			</TD>
		</TR>
		</TABLE>
	</TD>
</TR>
</TABLE>

<TABLE BORDER="0" CELLSPACING="1" CELLPADDING="1" WIDTH="100%" class="current_location_table">
<TR>
	<TD ALIGN="RIGHT" WIDTH="1%" NOWRAP VALIGN="TOP" class="current_location_title">&nbsp;<?php putGS("Publication"); ?>:</TD>
	<TD VALIGN="TOP" class="current_location_content"><?php echo htmlspecialchars($publicationObj->getName()); ?></TD>

	<TD ALIGN="RIGHT" WIDTH="1%" NOWRAP VALIGN="TOP" class="current_location_title">&nbsp;<?php putGS("Issue"); ?>:</TD>
	<TD VALIGN="TOP" class="current_location_content"><?php echo $issueObj->getIssueId(); ?>. <?php echo htmlspecialchars($issueObj->getName()); ?> (<?php echo htmlspecialchars($issueLanguage->getName()); ?>)</TD>

	<TD ALIGN="RIGHT" WIDTH="1%" NOWRAP VALIGN="TOP" class="current_location_title">&nbsp;<?php putGS("Section"); ?>:</TD>
	<TD VALIGN="TOP" class="current_location_content"><?php echo $sectionObj->getSectionId(); ?>. <?php echo htmlspecialchars($sectionObj->getName()); ?></TD>

	<TD ALIGN="RIGHT" WIDTH="1%" NOWRAP VALIGN="TOP" class="current_location_title">&nbsp;<?php putGS("Article"); ?>:</TD>
	<TD VALIGN="TOP" class="current_location_content"><?php echo htmlspecialchars($articleObj->getTitle()); ?> (<?php echo htmlspecialchars($articleLanguage->getName()); ?>)</TD>
</TR>
</TABLE>

<table width="100%" border="0">
<tr>
	<td style="padding:20px;" align="center">
		Here you can upload an article that has been written in Open Office (files with extension ".sxw").  Click <a href="CampsiteArticleTemplate.stw">here</a> to get the template.
	</td>
</tr>
</table>

<table border="0" align="center" cellspacing="0" class="table_input">
<form method="POST" action="CommandProcessor.php" onsubmit="return validateForm(this, 0, 1, 0, 1, 0);" enctype="multipart/form-data">
<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
<input type="hidden" name="form_name" value="upload_article_form">
<input type="hidden" name="Pub" value="<?php echo $Pub ?>">
<input type="hidden" name="Issue" value="<?php echo $Issue ?>">
<input type="hidden" name="Section" value="<?php echo $Section ?>">
<input type="hidden" name="Article" value="<?php echo $Article ?>">
<input type="hidden" name="Language" value="<?php echo $Language ?>">
<!-- BEGIN: The following fields are needed for edit.php -->
<input type="hidden" name="sLanguage" value="<?php echo $sLanguage ?>">
<!-- END -->
<tr>
	<td align="left" colspan="2" style="padding: 6px">
		<B>Article Import</B>
		<HR NOSHADE SIZE="1" COLOR="BLACK"> 		
	</td>
</tr>
<tr>
	<td style="padding: 6px;">
		Upload File:
	</td>
	
	<td style="padding: 6px;">
		<input type="file" name="filename" size="55" value="" alt="file|sxw" emsg="The file name must have an extension of .sxw" class="input_file">
	</td>
	
</tr>
<tr>
	<td colspan="2">
		<table width="100%">
		<tr>
			<td align="right" style="padding: 3px;" >
				<INPUT type="submit" name="Submit" value="Upload" class="button">
			</td>
			<td align="left" style="padding: 3px;">
				<INPUT type="button" name="Cancel" value="Cancel" class="button" ONCLICK="location.href='/<?php echo $ADMIN; ?>/pub/issues/sections/articles/edit.php?Pub=<?php p($Pub); ?>&Issue=<?php p($Issue); ?>&Section=<?php p($Section); ?>&Article=<?php p($Article) ?>&Language=<?php p($Language); ?>&sLanguage=<?php p($sLanguage) ?>'">
			</td>
		</tr>
		</table>
	</td>
</tr>
</form>
</table>