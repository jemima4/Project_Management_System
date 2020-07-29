<?php
//test fucntion for conversion
// $myfile = fopen("projects/e10adc3949ba59abbe56e057f20f883e/10631349.docx", "r") or die("Unable to open file!");
// $holder =  fread($myfile,filesize("projects/e10adc3949ba59abbe56e057f20f883e/10631349.docx"));
// echo $holder;
// fclose($myfile);
// $filePath = "./projects/e10adc3949ba59abbe56e057f20f883e/10631349.docx";
$filePath = "./projects/e10adc3949ba59abbe56e057f20f883e/";
// $hl = readDocx($filePath);
// echo $hl; 
function readDocx($filePath) {
    // Create new ZIP archive
    $zip = new ZipArchive;
    $dataFile = 'word/document.xml';
    // Open received archive file
    if (true === $zip->open($filePath)) {
        // If done, search for the data file in the archive
        if (($index = $zip->locateName($dataFile)) !== false) {
            // If found, read it to the string
            $data = $zip->getFromIndex($index);
            // Close archive file
            $zip->close();
            // Load XML from a string
            // Skip errors and warnings
            $xml = DOMDocument::loadXML($data, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
            // Return data without XML formatting tags
            $contents = explode('\n',strip_tags($xml->saveXML()));
            $text = '';
            foreach($contents as $i=>$content) {
                $text .= $contents[$i];
            }
            return $text;
        }
        $zip->close();
    }
    // In case of failure return empty string
    return "";
}

// $docObj = new DocxConversion($filePath);
// echo $docText= $docObj->convertToText();

class DocxConversion{
    private $filename;

    public function __construct($filePath) {
        $this->filename = $filePath;
    }

    private function read_doc() {
        $fileHandle = fopen($this->filename, "r");
        $line = @fread($fileHandle, filesize($this->filename));   
        $lines = explode(chr(0x0D),$line);
        $outtext = "";
        foreach($lines as $thisline)
          {
            $pos = strpos($thisline, chr(0x00));
            if (($pos !== FALSE)||(strlen($thisline)==0))
              {
              } else {
                $outtext .= $thisline." ";
              }
          }
         $outtext = preg_replace("/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/","",$outtext);
        return $outtext;
    }

    private function read_docx(){

        $striped_content = '';
        $content = '';

        $zip = zip_open($this->filename);

        if (!$zip || is_numeric($zip)) return false;

        while ($zip_entry = zip_read($zip)) {

            if (zip_entry_open($zip, $zip_entry) == FALSE) continue;

            if (zip_entry_name($zip_entry) != "word/document.xml") continue;

            $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

            zip_entry_close($zip_entry);
        }// end while

        zip_close($zip);

        // $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
        // $content = str_replace('</w:r></w:p>', "\r\n", $content);
        // $striped_content = strip_tags($content);

        $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
        $content = str_replace('</w:r></w:p>', "\r\n", $content);
        $content = preg_replace('/<w:p w[0-9-Za-z]+:[a-zA-Z0-9]+="[a-zA-z"0-9 :="]+">/',"\n\r",$content);
        $content = preg_replace('/<w:tr>/',"\n\r",$content);
        $content = preg_replace('/<w:tab\/>/',"\t",$content);
        $content = preg_replace('/<\/w:p>/',"\n\r",$content);
        $striped_content = strip_tags($content);

        return $striped_content;
    }

 /************************excel sheet************************************/

function xlsx_to_text($input_file){
    $xml_filename = "xl/sharedStrings.xml"; //content file name
    $zip_handle = new ZipArchive;
    $output_text = "";
    if(true === $zip_handle->open($input_file)){
        if(($xml_index = $zip_handle->locateName($xml_filename)) !== false){
            $xml_datas = $zip_handle->getFromIndex($xml_index);
            $xml_handle = DOMDocument::loadXML($xml_datas, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
            $output_text = strip_tags($xml_handle->saveXML());
        }else{
            $output_text .="";
        }
        $zip_handle->close();
    }else{
    $output_text .="";
    }
    return $output_text;
}

/*************************power point files*****************************/
function pptx_to_text($input_file){
    $zip_handle = new ZipArchive;
    $output_text = "";
    if(true === $zip_handle->open($input_file)){
        $slide_number = 1; //loop through slide files
        while(($xml_index = $zip_handle->locateName("ppt/slides/slide".$slide_number.".xml")) !== false){
            $xml_datas = $zip_handle->getFromIndex($xml_index);
            $xml_handle = DOMDocument::loadXML($xml_datas, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
            $output_text .= strip_tags($xml_handle->saveXML());
            $slide_number++;
        }
        if($slide_number == 1){
            $output_text .="";
        }
        $zip_handle->close();
    }else{
    $output_text .="";
    }
    return $output_text;
}


    public function convertToText() {

        if(isset($this->filename) && !file_exists($this->filename)) {
            return "File Not exists";
        }

        $fileArray = pathinfo($this->filename);
        $file_ext  = $fileArray['extension'];
        if($file_ext == "doc" || $file_ext == "docx" || $file_ext == "xlsx" || $file_ext == "pptx")
        {
            if($file_ext == "doc") {
                return $this->read_doc();
            } elseif($file_ext == "docx") {
                return $this->read_docx();
            } elseif($file_ext == "xlsx") {
                return $this->xlsx_to_text();
            }elseif($file_ext == "pptx") {
                return $this->pptx_to_text();
            }
        } else {
            return "Invalid File Type";
        }
    }

}
deleteFile($filePath);
function deleteFile($filePath)
{
    echo "Delete file running";
    //Experimental
    // unlink(dirname(__FILE__) . $filepath);
    // if(is_writable($filepath))
    // {
    //     unlink(dirname(__FILE__) . $filepath);
    // }
    // else
    // {
    //     echo "File is not writable"; 
    // }
    ///////////////////////
    gc_collect_cycles();
    if(!mkdir($filePath))
    {
        echo "testing" ;      
    }
    if(is_dir($filePath))
    {
        echo "</br>";
        echo "1as";
        $files = glob($filePath . '*', GLOB_MARK);
        foreach($files as $file)
        {
            unlink($file);
            // delete_files($file);
        }
        rmdir($filePath);
    }
    elseif(is_file($filePath))
    {
        echo "2bd";
        unlink($filePath);
    }
    ///////////
    // $file_pointer = fopen($filePath, 'w+');
    // if (!unlink($filePath)) {  
    //     echo ("cannot be deleted due to an error");  
    // }  
    // else {  
    //     echo ("$filePath has been deleted");  
    // }  
}

?>

