<?php

class CSVReader
{
    protected string $filepath;
    protected array $head;
    protected array $rows;

    public function __construct(string $filepath)
    {
        $this->filepath = $filepath;
        $this->load();
    }

    public function getRows(): array
    {
        return $this->rows;
    }

    public function getCount(): int
    {
        return count($this->rows);
    }

    public function getHead(): array
    {
        return $this->head;
    }

    protected function load(): bool
    {
        if (($handle = fopen($this->filepath, "r")) !== false) {
            $row = 1;
            while (($data = fgetcsv($handle, 1000, ";")) !== false) {
                if ($row == 1) {
                    $this->head = $data;
                    $row++;
                    continue;
                }
                $this->rows[] = $data;
                $row++;
            }
            fclose($handle);
            return true;
        }

        return false;
    }
}
