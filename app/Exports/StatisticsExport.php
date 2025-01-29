<?php

namespace App\Exports;

use App\Models\Project;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StatisticsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Project::select('id', 'title', 'sector', 'budget', 'status', 'created_at')->get();
    }

    public function headings(): array
    {
        return [
            'ID', 'Titre', 'Secteur', 'Budget', 'Statut', 'Date de création'
        ];
    }
}
