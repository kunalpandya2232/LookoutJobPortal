<?php



namespace config\settingsFiles;
class settingsFiles
{
    public $session = [];
    public function get_required_files()
    {
        require_once "generalFiles.php";
        require_once "dbFIles.php";
    }

    public function get_header($pageName = null)
    {
        require _DIR . "/header.php";
    }

    public function get_footer($data=true)
    {
        require _DIR . "/footer.php";
    }

    public function get_valid_checker()
    {
        require _DIR . "/etc/checker/validChecker.php";
    }
    public function get_header_admin($pageName = null)
    {
        require _DIR_ADMIN. "/header.php";
    }
    public function get_footer_admin($data=true)
    {
        require _DIR_ADMIN . "/footer.php";
    }

    public function getMailFile()
    {
        require "mailFile.php";
    }
}
