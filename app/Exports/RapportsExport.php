<?php

namespace App\Exports;

use App\Models\views\V_Mouvement;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RapportsExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $rapports = V_Mouvement::select(
            'code_produit',
            'nom',
            'reste_en_stock',
            'seuil_reapprovisionnement',
            'unite',
            'emplacement',
            'date_mouvement',
            'duree_limite',
            'categorie',
            'type_categorie'
        )
            ->where('reste_en_stock', '!=', 0)
            ->get();

        $result = $rapports->map(function ($rapport) {
            // Calcul de l'alerte de seuil
            $alerte_seuil = $rapport->reste_en_stock <= $rapport->seuil_reapprovisionnement ? 'Alert' : '';

            // Calcul de l'alerte sur les dates
            $date_seuil = !empty($rapport->duree_limite)
                ? Carbon::parse($rapport->date_mouvement)->addDays($rapport->duree_limite)->format('Y-m-d')
                : null;
            $alerte_date = !empty($date_seuil) && Carbon::now()->gt(Carbon::parse($date_seuil)) ? 'Expiré' : '';

            return [
                'code_produit' => $rapport->code_produit,
                'nom' => $rapport->nom,
                'reste_en_stock' => $rapport->reste_en_stock,
                'seuil_reapprovisionnement' => $rapport->seuil_reapprovisionnement,
                'unite' => $rapport->unite,
                'emplacement' => $rapport->emplacement,
                'date_mouvement' => Carbon::parse($rapport->date_mouvement)->format('Y-m-d'),
                'date_seuil' => $date_seuil,
                'alerte_seuil' => $alerte_seuil,
                'alerte_date' => $alerte_date,
                'categorie' => $rapport->categorie,
                'type_categorie' => $rapport->type_categorie,
            ];
        });

        return collect($result);
    }

    /**
     * En-têtes des colonnes.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Code',
            'Désignation',
            'Stock',
            'Seuil',
            'Unite',
            'Emplacement',
            'Date entrée',
            'Date seuil',
            'Alerte seuil',
            'Alerte date',
            'Categorie',
            'Type',
        ];
    }

    /**
     * Styles pour le fichier Excel.
     *
     * @param Worksheet $sheet
     * @return array|void
     */
    public function styles(Worksheet $sheet)
    {
        // Mettre les en-têtes en gras et en gris clair
        $sheet->getStyle('A1:L1')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => 'solid',
                'color' => ['rgb' => 'D9D9D9'], // Gris clair
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'], // Noir
                ],
            ],
        ]);

        // Appliquer des styles conditionnels pour les lignes
        $rows = $sheet->toArray();
        foreach ($rows as $index => $row) {
            if ($index > 0) { // Éviter la première ligne (en-têtes)
                $currentRow = $index + 1;

                // Style pour alerte seuil (rouge clair)
                if ($row[8] === 'Alert') {
                    $sheet->getStyle("A$currentRow:L$currentRow")->applyFromArray([
                        'fill' => [
                            'fillType' => 'solid',
                            'color' => ['rgb' => 'FFC7CE'], // Rouge clair
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['rgb' => '000000'], // Noir
                            ],
                        ],
                    ]);
                }

                // Style pour expiré (bleu clair)
                if ($row[9] === 'Expiré') {
                    $sheet->getStyle("A$currentRow:L$currentRow")->applyFromArray([
                        'fill' => [
                            'fillType' => 'solid',
                            'color' => ['rgb' => 'CFE2F3'], // Bleu clair
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['rgb' => '000000'], // Noir
                            ],
                        ],
                    ]);
                }

                // Bordures par défaut pour toutes les autres lignes
                $sheet->getStyle("A$currentRow:L$currentRow")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Noir
                        ],
                    ],
                ]);
            }
        }
    }
}
