<?

class GPIOFile {
    private function fileHandler() {
       echo "returning a file object\n"; 
    }
    
    public function __construct($path)
    {
        // Prime GPIO bus.
        $this->path = $path;
    }

    public function write($filename, $value)
    {
        $handle = fopen('file://' . $filename, 'w');
        if ($handle != NULL)
        {
            $written = fwrite($handle, $value);
            print "Wrote $written to $filename\n";
            fclose($handle);
        }
    }

    public function read($filename)
    {
         return file_get_contents('file://' . $filename);
    }
}

class GPIO {
    private function mNumber()
    {
        print "GPIO private function\n";  
    }
    
    public function __construct($pin) 
    {
        $this->pin = $pin;
        $this->path = '/sys/class/gpio/gpio' . $this->pin;
        $this->io = new GPIOFile($this->path);
    }
  
    public function setValue($value)
    {
        $file = 'value';
        $this->value = $value;
        // Set logic value of pin.
        $this->io->write($this->path . '/' . $file, $this->value);
    }
    
    public function getValue($value)
    {
        return $this->io->read($this->path . '/' . $value);
    }

    public function setDirection($direction)
    {
        $this->direction = $direction;
        // Set direction of pin.
        //$this->io = new GPIOFile($this->path . 'direction');
    }
}


$pin27 = new GPIO(27);
//print_r($pin27);

$pin27->setDirection('out');
//print_r($pin27);

$pin27->setValue('0');
//print_r($pin27);

$value = $pin27->getValue('value');
print "Value is: $value\n";

$value = $pin27->getValue('direction');
print "Direction is: $value\n";




/**
 *
class LinuxFile
{
  private:
    int m_Handle;
  public:
    LinuxFile(const char *pFile, int flags = O_RDWR)
    {
      m_Handle = open(pFile, flags);
    }
    LinuxFile()
    {
      if (m_Handle != -1)
        close(m_Handle);
    }
    size_t Write(const void *pBuffer, size_t size)
    {
      return write(m_Handle, pBuffer, size);
    }
    size_t Read(void *pBuffer, size_t size)
    {
      return read(m_Handle, pBuffer, size);
    }
    size_t Write(const char *pText)
    {
      return Write(pText, strlen(pText));
    }
    size_t Write(int number)
    {
      char szNum[32];
      snprintf(szNum, sizeof(szNum), "%d", number);
      return Write(szNum);
    }
};

class LinuxGPIOExporter
{
  protected:
    int m_Number;
  public:
    LinuxGPIOExporter(int number)
    : m_Number(number)
    {}
    void SetValue(bool value)
    {
      char szFN[128];
      snprintf(szFN, sizeof(szFN), 
      "/sys/class/gpio/gpio%d/value", m_Number);
      LinuxFile(szFN).Write(value ? "1" : "0");
    }
    void SetDirection(bool isOutput)
    {
      char szFN[128];
      snprintf(szFN, sizeof(szFN), 
      "/sys/class/gpio/gpio%d/direction", m_Number);
      LinuxFile(szFN).Write(isOutput ? "out" : "in");
    }
};

int main(int argc, char *argv[])
{
  LinuxGPIO gpio27(27);
  gpio27.SetDirection(true);
  bool on = true;
  for (;;)
  {
    printf("Switching %s the LED...\n", on ? "on" : "off");
    gpio27.SetValue(on);
    on = !on;
    sleep(1);
  }
}

 */



