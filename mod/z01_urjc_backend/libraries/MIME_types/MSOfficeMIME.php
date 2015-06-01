<?php

function getMicrosoftOfficeMimeInfo($file) {
    $fileInfo = array('word/' => array('type' => 'Microsoft Word 2007+', 'mime' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'extension' => 'docx'), 'ppt/' => array('type' => 'Microsoft PowerPoint 2007+', 'mime' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'extension' => 'pptx'), 'xl/' => array('type' => 'Microsoft Excel 2007+', 'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'extension' => 'xlsx'));
    $pkEscapeSequence = "PK\x03\x04";
    $file = new BinaryFile($file);
    if ($file->bytesAre($pkEscapeSequence, 0x00)) {
        if ($file->bytesAre('[Content_Types].xml', 0x1E)) {
            if ($file->search($pkEscapeSequence, null, 2000)) {
                if ($file->search($pkEscapeSequence, null, 1000)) {
                    $offset = $file->tell() + 26;
                    foreach ($fileInfo as $searchWord => $info) {
                        $file->seek($offset);
                        if ($file->bytesAre($searchWord)) {
                            return $fileInfo[$searchWord];
                        }
                    }
                    return array('type' => 'Microsoft OOXML', 'mime' => null, 'extension' => null);
                }
            }
        }
    }
    return false;
}

class BinaryFile_Exception extends Exception {
}

class BinaryFile_Seek_Method {
    const ABSOLUTE = 1;
    const RELATIVE = 2;
}

class BinaryFile {
    const SEARCH_BUFFER_SIZE = 1024;
    private $handle;

    public function __construct($file) {
        $this->handle = fopen($file, 'r');
        if ($this->handle === false) {
            throw new BinaryFile_Exception('Cannot open file');
        }
    }

    public function __destruct() {
        fclose($this->handle);
    }

    public function tell() {
        return ftell($this->handle);
    }

    public function seek($offset, $seekMethod = null) {
        if ($offset !== null) {
            if ($seekMethod === null) {
                $seekMethod = BinaryFile_Seek_Method::ABSOLUTE;
            }
            if ($seekMethod === BinaryFile_Seek_Method::RELATIVE) {
                $offset += $this->tell();
            }
            return fseek($this->handle, $offset);
        } else {
            return true;
        }
    }

    public function read($length) {
        return fread($this->handle, $length);
    }

    public function search($string, $offset = null, $maxLength = null) {
        if ($offset !== null) {
            $this->seek($offset);
        } else {
            $offset = $this->tell();
        }
        $bytesRead = 0;
        $bufferSize = ($maxLength !== null ? min(self::SEARCH_BUFFER_SIZE, $maxLength) : self::SEARCH_BUFFER_SIZE);
        while ($read = $this->read($bufferSize)) {
            $bytesRead += strlen($read);
            $search = strpos($read, $string);
            if ($search !== false) {
                $this->seek($offset + $search + strlen($string));
                return true;
            }
            if ($maxLength !== null) {
                $bufferSize = min(self::SEARCH_BUFFER_SIZE, $maxLength - $bytesRead);
                if ($bufferSize == 0) {
                    break;
                }
            }
        }
        return false;
    }

    public function getBytes($length, $offset = null, $seekMethod = null) {
        $this->seek($offset, $seekMethod);
        $read = $this->read($length);
        return $read;
    }

    public function bytesAre($string, $offset = null) {
        return ($this->getBytes(strlen($string), $offset) == $string);
    }
}
