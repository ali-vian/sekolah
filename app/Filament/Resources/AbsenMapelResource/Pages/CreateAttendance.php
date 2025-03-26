<?php

namespace App\Filament\Resources\AbsenMapelResource\Pages;

use App\Filament\Resources\AbsenMapelResource;
use Filament\Forms\Components\View;
use App\Models\AbsenMapel;
use App\Models\Student;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Button;

class CreateAttendance extends Page
{
    
    use InteractsWithForms;

    protected static string $resource = AbsenMapelResource::class;

    protected static string $view = 'filament.resources.create-attendance';
    
    public ?array $data = [];
    
    // Student attendance statuses
    public array $attendance = [];
    
    public function mount(): void
    {
        $this->form->fill([
            'tanggal_absen' => now()->format('Y-m-d'),
            'jadwal_id' =>12,
        ]);
        
        // Initialize attendance status for all students to 'Hadir'
        $students = $this->getStudents();
        foreach ($students as $student) {
            $this->attendance[$student->id] = 'Hadir';
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        DatePicker::make('tanggal_absen')
                            ->label('Tanggal Absensi')
                            ->required()
                            ->default(now())
                            ->columnSpan(1),
                            
                        Select::make('jadwal_id')
                            ->label('Jadwal')
                            // ->relationship('jadwal', 'nama_jadwal')
                            // ->required()
                            ->columnSpan(1),
                    ])
            ])
            ->statePath('data')
            ;
    }
    
    public function getStudents()
    {
        return Student::orderBy('name')->get();
    }
    
    public function setAttendanceStatus($studentId, $status)
    {
        $this->attendance[$studentId] = $status;
    }

    public function save(): void
    {
        
        // DEBUG - Check what data we're working with
        info('Form Data:', $this->data);
        info('Attendance Data:', $this->attendance);
        
        $this->validate([
            'data.tanggal_absen' => 'required|date',
            'data.jadwal_id' => 'required|exists:jadwal,id',
        ]);
        
        $tanggalAbsen = Carbon::parse($this->data['tanggal_absen'])->startOfDay();
        $jadwalId = $this->data['jadwal_id'];
        $savedCount = 0;
        
        // Use the attendance array directly
        foreach ($this->attendance as $studentId => $status) {
            try {
                // Check if record already exists
                $existingRecord = AbsenMapel::where('student_id', $studentId)
                    ->whereDate('waktu_absen', $tanggalAbsen)
                    ->where('jadwal_id', $jadwalId)
                    ->first();
                
                if ($existingRecord) {
                    // Update existing record
                    $existingRecord->status = $status;
                    $existingRecord->save();
                    $savedCount++;
                } else {
                    // Create new record
                    AbsenMapel::create([
                        'student_id' => $studentId,
                        'waktu_absen' => $tanggalAbsen,
                        'jadwal_id' => $jadwalId,
                        'status' => $status,
                    ]);
                    $savedCount++;
                }
            } catch (\Exception $e) {
                // Log any database errors
                info("Error saving attendance for student ID: {$studentId}", [
                    'error' => $e->getMessage()
                ]);
            }
        }

        Notification::make()
            ->title("Absensi berhasil disimpan ({$savedCount} siswa)")
            ->success()
            ->send();
            
        // Redirect to the list page after saving
        // return redirect()->route('filament.admin.resources.attendances.index');
    }
}

