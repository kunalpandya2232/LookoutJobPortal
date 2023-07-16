<?php



abstract class validToUpload
{
    protected $file;
    public    $status;

    abstract protected function validToUploadFunc(array $file, $type = '',  $fieldname);
}

class uploadImageFunc extends validToUpload
{
    protected $fDir  = _UPLOAD . 'images/';
    protected $iFn   = '';
    protected $fFile = '';

    public function validToUploadFunc(array $file, $type = '',  $fieldname)
    {
        $ret = false;
        // TODO: Implement validToUploadFunc() method.
        if ($type != '') {
            $this->file = $file;
            $this->iFn  = $fieldname;
            $ret        = $this->imageCheck();
        }
        return $ret;
    }

    private function imageCheck()
    {
        $this->fFile  = $this->fDir . basename($this->file[$this->iFn]['name']);
        $this->status = ['fake' => '', 'size' => '', 'ext' => ''];
        //check image is real or fake
        $this->imageRealorFake();
        //check image size
        $this->imageSize();
        //check image necessary extension
        $this->allowExt();
        //check existence file
        $this->exists();

        return $this->checkStatus();
    }

    private function imageRealorFake()
    {
        $check = getimagesize($this->file[$this->iFn]["tmp_name"]);
        if (!$check) {
            $this->status['fake'] = "File is not an image";
        }
    }
    private function exists()
    {

        $check = true;
        if(file_exists($this->fFile)){
            $check = false;
        }
        if (!$check) {
            $this->status['fake'] = "Image is exists";
        }
    }

    private function imageSize()
    {
        if ($this->file[$this->iFn]['size'] > 500000) {
            $this->status['size'] = "Image is large";
        }
    }

    private function allowExt()
    {
        $ext      = strtolower(pathinfo($this->fFile, PATHINFO_EXTENSION));
        $allowExt = ['jpeg', 'jpg'];
        if (!in_array($ext, $allowExt)) {
            $this->status['ext'] = "Sorry only " . implode(", ", $allowExt) . " files are allowed.";
        }
    }

    private function checkStatus()
    {
        $status    = true;
        $newStatus = [];
        foreach ($this->status as $key => $value) {
            if ($value != '') {
                $newStatus[$key] = $value;
                $status          = 'error';
            }
        }
        $this->status = $newStatus;
        return $status;
    }
}

class uploadResumeFunc extends validToUpload
{
    protected $fDir = _UPLOAD . 'resumes/';

    public function validToUploadFunc(array $file, $type = '', $fieldname)
    {
        // TODO: Implement validToUploadFunc() method.
        if ($type != '') {
            $this->file = $file;
            $this->iFn  = $fieldname;

            $ret        = $this->resumeCheck();
        }
        return $ret;
    }

    private function resumeCheck()
    {
        $this->fFile  = $this->fDir . basename($this->file[$this->iFn]['name']);
        $this->exists();
        $this->resumeSize();
        $this->allowExt();
        return $this->checkStatus();
    }
    private function exists()
    {

        $check = true;
        if(file_exists($this->fFile)){
            $check = false;
        }
        if (!$check) {
            $this->status[] = "Resume is exists";
        }
    }

    private function resumeSize()
    {
        if ($this->file[$this->iFn]['size'] > 500000) {
            $this->status[] = "Resume is large";
        }
    }

    private function allowExt()
    {
        $ext      = strtolower(pathinfo($this->fFile, PATHINFO_EXTENSION));
        $allowExt = ['pdf'];
        if (!in_array($ext, $allowExt)) {
            $this->status[] = "Sorry only PDF file are allowed.";
        }
    }

    private function checkStatus()
    {
        $status    = true;
        $newStatus = [];
        if($this->status) {
            foreach ($this->status as $key => $value) {
                if ($value != '') {
                    $newStatus[$key] = $value;
                    $status          = 'error';
                }
            }
        }
        $this->status = $newStatus;
        return $status;
    }
}
