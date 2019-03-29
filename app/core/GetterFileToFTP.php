<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetterFileToFTP
 *
 * @author Admin
 */
class GetterFileToFTP {
    private $userName;
	private $pass;
	private $host;
	private $remoteFile;
	private $localFile;
	private $ftpConnect;

	function __construct(Array $listArgs = [])
	{
		if (!empty($listArgs)) {
			foreach ($listArgs as $key => $value) {

				$methodName = 'set' . $key;

				if ($this->propertyExists($key) && $this->methodExists($methodName)) {
					$this->$methodName($value);
				} 

			}
		}

		if ($this->host) {

        }
	}

    /**
     * @param String $property
     * @return bool
     * if property exist in this class would return true else false
     */
    private function propertyExists(String $property): bool
    {
        return property_exists(__CLASS__, $property);
    }

    /**
     * @param $methodName
     * @return bool
     * if method exist in this class would return true else false
     */
    private function methodExists($methodName)
    {
        return method_exists(__CLASS__, $methodName);
    }

    /**
     * @param String|null $host
     * @return resource
     * @throws Exception
     *
     * would return resource FTP connect. If failed to create or login connect trow exception
     */
    private function createFTPConnect(?String $host = null)
    {
        if ($host || $this->host) {
            $host = $host ? $host : $this->host;
        } else {
            throw new Exception('Host not set');
        }

        $connect = ftp_connect($host);

        if ($connect) {
            $this->ftpConnect = $connect;

            if ($this->FTPLogin()) {
                return $connect;
            } else {
                throw new Exception('Failed to login connect');
            }

        } else {
            throw new Exception('Failed to create connect');
        }
    }

    /**
     * @param String|null $userName
     * @param String|null $pass
     * @return bool
     *
     */
    private function FTPLogin(?String $userName = null, ?String $pass = null): bool
    {
        $userName = $userName ? $userName : $this->userName;
        $pass = $pass ? $pass : $this->pass;
        $connect = $this->ftpConnect;

        return ftp_login($connect, $userName, $pass);
    }

    /**
     * @return bool
     * @throws Exception
     * method to get a remote file and write in a local file
     */
    function writeToFile(): bool
    {
        $localFile = $this->localFile;
        $remoteFile = $this->remoteFile;

        if (!($localFile && $remoteFile)) {
            throw new Exception('Local or remote files not set');
        }

        $connect = $this->ftpConnect ? $this->ftpConnect : $this->createFTPConnect();

        return ftp_get($connect, $localFile, $remoteFile, FTP_BINARY);
    }

    /**
     * below setter and getter methods for exist properties
     *
     */

	private function setUserName(String $userName)
	{
		$this->userName = $userName;
	}

    private function setHost(String $host)
	{
		$this->host = $host;
	}

    private function setRemoteFile(String $remoteFile)
	{
		$this->remoteFile = $remoteFile;
	}

    private function setPass(String $pass)
    {
        $this->pass = $pass;
    }

    /**
     * @param String $localFile
     * @throws Exception
     */
    private function setLocalFile(String $localFile)
	{
        if (!(file_exists($localFile) && is_writable($localFile))) {
            throw new Exception('File not exist or not writable');
        }
		$this->localFile = $localFile;
	}
}
