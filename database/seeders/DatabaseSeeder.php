<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Divisi;
use App\Models\Departemen;
use App\Models\Jabatan;
use App\Models\Rekrutmen;
use App\Models\Karyawan;
use App\Models\MppPosition;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedUsers();
        $this->seedMasterData();
        $this->seedRekrutmen();
        $this->seedKaryawan();
        $this->seedMpp();
    }

    private function seedUsers(): void
    {
        $users = [
            ['name'=>'Administrator','username'=>'admin','email'=>'admin@scm-konawe.com','role'=>'admin'],
            ['name'=>'HR Manager','username'=>'hrmanager','email'=>'hrmanager@scm-konawe.com','role'=>'hr_manager'],
            ['name'=>'HR Staff','username'=>'hrstaff','email'=>'hrstaff@scm-konawe.com','role'=>'hr_staff'],
            ['name'=>'Viewer','username'=>'viewer','email'=>'viewer@scm-konawe.com','role'=>'viewer'],
        ];
        foreach ($users as $u) {
            User::firstOrCreate(['email'=>$u['email']], array_merge($u, ['password'=>Hash::make('password123'), 'is_active'=>true]));
        }
    }

    private function seedMasterData(): void
    {
        $divisData = [
            'Commercial & IT', 'Community Affairs', 'Compliance & Environmental',
            'Estate Management', 'Exploration & Resources Development',
            'Finance, Accounting & Tax', 'General Facility & Maintenance',
            'HRBP & Corporate Services', 'HRGA Operation', 'Legal', 'Management',
            'Mine Engineering', 'Mine Geology & QA', 'OHS & Assets Protection',
            'Operation', 'Ore Haulage', 'Research & Development',
            'Reserve Optimization & Long Term Planning',
            'Strategic Project & Infrastructure', 'Supply Chain Management',
            'Sustainability', 'Compliance', 'Project Limestone',
        ];
        foreach ($divisData as $nama) {
            Divisi::firstOrCreate(['nama'=>$nama], ['is_active'=>true]);
        }

        $deptMap = [
            'Strategic Project & Infrastructure' => ['Construction Services','Engineering & Capital Project','Mine Development'],
            'General Facility & Maintenance'     => ['General Facility & Maintenance','Electrical & Instrument'],
            'OHS & Assets Protection'            => ['Occupational Health & Safety','Assets Protection','Industrial Hygiene Occupational Health'],
            'Operation'                          => ['Mine Operation','Survey','Production & Cost Engineering','Production Engineering'],
            'Community Affairs'                  => ['Community Affairs','Corporate Social Responsibility','Government Relation'],
            'Mine Geology & QA'                  => ['Mine Geology','Quality Assurance'],
            'Commercial & IT'                    => ['Commercial & IT','Data Center'],
            'Mine Engineering'                   => ['Mine Planning','Geotech & Hydrology','Mine Readiness','Mine Engineering'],
            'Compliance & Environmental'         => ['Compliance & Forestry','Environmental Operation','Compliance & Permit'],
            'Exploration & Resources Development'=> ['Exploration Drilling','Geophysicist & District Exploration','Database & Geologist Evaluation'],
            'HRGA Operation'                     => ['Human Resources','General Affairs','Industrial Relation & Expatriate Permit'],
            'Finance, Accounting & Tax'          => ['Finance','Accounting & Tax'],
            'Ore Haulage'                        => ['Ore Haulage Engineering','Road Maintenance','Limonite Ore Haulage','Saprolite Ore Haulage'],
            'Research & Development'             => ['Business Development','Reserve Optimization & Long Term Planning'],
        ];

        foreach ($deptMap as $divNama => $depts) {
            $divisi = Divisi::where('nama', $divNama)->first();
            if (!$divisi) continue;
            foreach ($depts as $dNama) {
                Departemen::firstOrCreate(['nama'=>$dNama], ['divisi_id'=>$divisi->id,'is_active'=>true]);
            }
        }
    }

    private function seedRekrutmen(): void
    {
        $rows = [
            ['nama_lengkap'=>'Agus Salim','plan_job_title'=>'Mine Development Operator','category_level'=>'Non-Staff','gender'=>'Male','progress'=>'Compro','sourch'=>'PUS','sla'=>49,'month_name'=>'September','month_number'=>9,'year'=>2025,'divisi'=>'Strategic Project & Infrastructure','dept'=>'Mine Development','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Antonius Mapau','plan_job_title'=>'Mine Development Operator','category_level'=>'Non-Staff','gender'=>'Male','progress'=>'Compro','sourch'=>'PUS','sla'=>49,'month_name'=>'September','month_number'=>9,'year'=>2025,'divisi'=>'Strategic Project & Infrastructure','dept'=>'Mine Development','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Muamar Sino','plan_job_title'=>'Mine Development Operator','category_level'=>'Non-Staff','gender'=>'Male','progress'=>'Compro','sourch'=>'PUS','sla'=>49,'month_name'=>'September','month_number'=>9,'year'=>2025,'divisi'=>'Strategic Project & Infrastructure','dept'=>'Mine Development','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Pandi Usna','plan_job_title'=>'Mine Development Operator','category_level'=>'Non-Staff','gender'=>'Male','progress'=>'Compro','sourch'=>'PUS','sla'=>49,'month_name'=>'September','month_number'=>9,'year'=>2025,'divisi'=>'Strategic Project & Infrastructure','dept'=>'Mine Development','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Petrus Tonglo','plan_job_title'=>'Mine Development Operator','category_level'=>'Non-Staff','gender'=>'Male','progress'=>'Compro','sourch'=>'PUS','sla'=>49,'month_name'=>'September','month_number'=>9,'year'=>2025,'divisi'=>'Strategic Project & Infrastructure','dept'=>'Mine Development','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Febrizka Hayati','plan_job_title'=>'IT Helpdesk Officer','category_level'=>'Officer','gender'=>'Female','progress'=>'Compro','sourch'=>'Referral','sla'=>6,'month_name'=>'October','month_number'=>10,'year'=>2025,'divisi'=>'Commercial & IT','dept'=>'Commercial & IT','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Federika Agatha','plan_job_title'=>'Secretary','category_level'=>'Supervisor','gender'=>'Female','progress'=>'Compro','sourch'=>'Referral','sla'=>null,'month_name'=>'October','month_number'=>10,'year'=>2025,'divisi'=>'Research & Development','dept'=>'Business Development','status_ata'=>'Not Yet'],
            ['nama_lengkap'=>'Sandi Kurniawan','plan_job_title'=>'IHOH Officer','category_level'=>'Officer','gender'=>'Male','progress'=>'Compro','sourch'=>'Referral','sla'=>67,'month_name'=>'October','month_number'=>10,'year'=>2025,'divisi'=>'OHS & Assets Protection','dept'=>'Industrial Hygiene Occupational Health','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Nurdin Hamzah','plan_job_title'=>'Surveyor Aerial Mapping','category_level'=>'Officer','gender'=>'Male','progress'=>'Compro','sourch'=>'Referral','sla'=>25,'month_name'=>'November','month_number'=>11,'year'=>2025,'divisi'=>'Operation','dept'=>'Survey','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Faris Putra Norvfiyan','plan_job_title'=>'Mine Operation Readiness Foreman','category_level'=>'Officer','gender'=>'Male','progress'=>'Compro','sourch'=>'LinkedIn','sla'=>36,'month_name'=>'November','month_number'=>11,'year'=>2025,'divisi'=>'Mine Engineering','dept'=>'Mine Readiness','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Timothy Tobias','plan_job_title'=>'Senior Engineer Pit Service','category_level'=>'Supervisor','gender'=>'Male','progress'=>'Compro','sourch'=>'LinkedIn','sla'=>null,'month_name'=>'March','month_number'=>3,'year'=>2026,'divisi'=>'Mine Engineering','dept'=>'Mine Engineering','status_ata'=>'Full Approval'],
            // On Board
            ['nama_lengkap'=>'Qurrota Ayun','plan_job_title'=>'Electrical Engineer','category_level'=>'Officer','gender'=>'Male','progress'=>'On Board','sourch'=>'Referral','sla'=>30,'month_name'=>'January','month_number'=>1,'year'=>2024,'divisi'=>'General Facility & Maintenance','dept'=>'General Facility & Maintenance','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Didik Six Cahyono Wibowo','plan_job_title'=>'High Voltage Foreman','category_level'=>'Officer','gender'=>'Male','progress'=>'On Board','sourch'=>'Referral','sla'=>30,'month_name'=>'March','month_number'=>3,'year'=>2024,'divisi'=>'General Facility & Maintenance','dept'=>'General Facility & Maintenance','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Dirman Cahyono','plan_job_title'=>'Mechanic Supervisor','category_level'=>'Supervisor','gender'=>'Male','progress'=>'On Board','sourch'=>'Referral','sla'=>30,'month_name'=>'May','month_number'=>5,'year'=>2024,'divisi'=>'General Facility & Maintenance','dept'=>'General Facility & Maintenance','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Yohanis Dede','plan_job_title'=>'Electrical','category_level'=>'Non-Staff','gender'=>'Male','progress'=>'On Board','sourch'=>'Referral','sla'=>30,'month_name'=>'June','month_number'=>6,'year'=>2024,'divisi'=>'General Facility & Maintenance','dept'=>'General Facility & Maintenance','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Rober Limbongan','plan_job_title'=>'Mechanic','category_level'=>'Non-Staff','gender'=>'Male','progress'=>'On Board','sourch'=>'BSI','sla'=>30,'month_name'=>'July','month_number'=>7,'year'=>2024,'divisi'=>'General Facility & Maintenance','dept'=>'General Facility & Maintenance','status_ata'=>'Full Approval'],
            // Failed
            ['nama_lengkap'=>'Igo Pardede','plan_job_title'=>'Community Development Officer','category_level'=>'Officer','gender'=>'Male','progress'=>'Failed - Interview','priority'=>'P3','sourch'=>'Referral','sla'=>30,'month_name'=>'April','month_number'=>4,'year'=>2024,'divisi'=>'Community Affairs','dept'=>'Community Affairs','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Wiji Permadi','plan_job_title'=>'MEP Engineer','category_level'=>'Officer','gender'=>'Male','progress'=>'Failed - Interview','priority'=>'P2','sourch'=>'Referral','month_name'=>'May','month_number'=>5,'year'=>2024,'divisi'=>'Strategic Project & Infrastructure','dept'=>'Engineering & Capital Project','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Advenly Pangayouw','plan_job_title'=>'Safety Trainer','category_level'=>'Supervisor','gender'=>'Male','progress'=>'Failed - Interview','priority'=>'P2','sourch'=>'Referral','sla'=>30,'month_name'=>'May','month_number'=>5,'year'=>2024,'divisi'=>'OHS & Assets Protection','dept'=>'Occupational Health & Safety','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Anwar Holil Hadian','plan_job_title'=>'Safety Trainer','category_level'=>'Supervisor','gender'=>'Male','progress'=>'Failed - Interview','priority'=>'P2','sourch'=>'Referral','sla'=>30,'month_name'=>'May','month_number'=>5,'year'=>2024,'divisi'=>'OHS & Assets Protection','dept'=>'Occupational Health & Safety','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Agro Forestriawan Nugroho','plan_job_title'=>'Reclamation & Revegetation Supervisor','category_level'=>'Supervisor','gender'=>'Male','progress'=>'Failed - Interview','priority'=>'P1','sourch'=>'Referral','sla'=>30,'month_name'=>'May','month_number'=>5,'year'=>2024,'divisi'=>'Compliance & Environmental','dept'=>'Environmental Operation','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Almes Meigory','plan_job_title'=>'Community Development Officer','category_level'=>'Officer','gender'=>'Male','progress'=>'Failed - Interview','priority'=>'P3','sourch'=>'Referral','sla'=>30,'month_name'=>'May','month_number'=>5,'year'=>2024,'divisi'=>'Community Affairs','dept'=>'Community Affairs','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Giovani Tambunan','plan_job_title'=>'Community Development Officer','category_level'=>'Officer','gender'=>'Male','progress'=>'Failed - Interview','priority'=>'P3','sourch'=>'Referral','sla'=>30,'month_name'=>'May','month_number'=>5,'year'=>2024,'divisi'=>'Community Affairs','dept'=>'Community Affairs','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Nenden Aditya Pursita Ningrum','plan_job_title'=>'Community Development Officer','category_level'=>'Officer','gender'=>'Female','progress'=>'Failed - Interview','priority'=>'P3','sourch'=>'Referral','sla'=>30,'month_name'=>'May','month_number'=>5,'year'=>2024,'divisi'=>'Community Affairs','dept'=>'Community Affairs','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Anfansha Afkar','plan_job_title'=>'Community Relation Superintendent','category_level'=>'Assistant Manager','gender'=>'Male','progress'=>'Failed - Interview','priority'=>'P2','sourch'=>'Referral','sla'=>30,'month_name'=>'May','month_number'=>5,'year'=>2024,'divisi'=>'Community Affairs','dept'=>'Community Affairs','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Geri Rahmat Runandi','plan_job_title'=>'GIS & Aerial Map','category_level'=>'Officer','gender'=>'Male','progress'=>'Failed - Interview','priority'=>'P3','sourch'=>'Referral','sla'=>30,'month_name'=>'May','month_number'=>5,'year'=>2024,'divisi'=>'Operation','dept'=>'Survey','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Susanto','plan_job_title'=>'Safety Trainer','category_level'=>'Supervisor','gender'=>'Male','progress'=>'Failed - Interview','priority'=>'P2','sourch'=>'Referral','sla'=>30,'month_name'=>'May','month_number'=>5,'year'=>2024,'divisi'=>'OHS & Assets Protection','dept'=>'Occupational Health & Safety','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Zainal Arifin','plan_job_title'=>'Safety Trainer','category_level'=>'Supervisor','gender'=>'Male','progress'=>'Failed - Interview','priority'=>'P2','sourch'=>'Referral','sla'=>30,'month_name'=>'May','month_number'=>5,'year'=>2024,'divisi'=>'OHS & Assets Protection','dept'=>'Occupational Health & Safety','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Ahmad Firdaus A','plan_job_title'=>'Surveyor Leadhand','category_level'=>'Non-Staff','gender'=>'Male','progress'=>'Failed - Interview','sourch'=>'BSI','sla'=>25,'month_name'=>'June','month_number'=>6,'year'=>2024,'divisi'=>'Operation','dept'=>'Survey','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Diki Dimas Lestari','plan_job_title'=>'Exploration Drilling Leadhand','category_level'=>'Non-Staff','gender'=>'Male','progress'=>'Failed - Interview','sourch'=>'BSI','sla'=>30,'month_name'=>'June','month_number'=>6,'year'=>2024,'divisi'=>'Exploration & Resources Development','dept'=>'Exploration Drilling','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Kristian Lomba','plan_job_title'=>'Safety Trainer','category_level'=>'Supervisor','gender'=>'Male','progress'=>'Failed - Interview','sourch'=>'BSI','sla'=>30,'month_name'=>'June','month_number'=>6,'year'=>2024,'divisi'=>'OHS & Assets Protection','dept'=>'Occupational Health & Safety','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Andromedha','plan_job_title'=>'Electrical Superintendent','category_level'=>'Assistant Manager','gender'=>'Female','progress'=>'Failed - Interview','priority'=>'P1','sourch'=>'Referral','sla'=>30,'month_name'=>'May','month_number'=>5,'year'=>2024,'divisi'=>'General Facility & Maintenance','dept'=>'General Facility & Maintenance','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Saidi','plan_job_title'=>'Exploration Drilling Leadhand','category_level'=>'Non-Staff','gender'=>'Male','progress'=>'Failed - Interview','sourch'=>'BSI','sla'=>30,'month_name'=>'June','month_number'=>6,'year'=>2024,'divisi'=>'Exploration & Resources Development','dept'=>'Exploration Drilling','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Sunardi','plan_job_title'=>'Community Development Officer','category_level'=>'Officer','gender'=>'Male','progress'=>'Failed - Interview','sourch'=>'BSI','sla'=>30,'month_name'=>'June','month_number'=>6,'year'=>2024,'divisi'=>'Community Affairs','dept'=>'Community Affairs','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Vecky Robert Panekenan','plan_job_title'=>'Mine Operation Supervisor','category_level'=>'Supervisor','gender'=>'Male','progress'=>'Failed - Interview','sourch'=>'BSI','sla'=>30,'month_name'=>'June','month_number'=>6,'year'=>2024,'divisi'=>'Operation','dept'=>'Mine Operation','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Astina Aras','plan_job_title'=>'Document Project Control Officer','category_level'=>'Officer','gender'=>'Male','progress'=>'Failed - Interview','priority'=>'NP','sourch'=>'Referral','sla'=>30,'month_name'=>'July','month_number'=>7,'year'=>2024,'divisi'=>'Strategic Project & Infrastructure','dept'=>'Engineering & Capital Project','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Muthia Muthmainnah Silondae','plan_job_title'=>'Document Project Control Officer','category_level'=>'Officer','gender'=>'Female','progress'=>'Failed - Interview','priority'=>'NP','sourch'=>'Referral','sla'=>30,'month_name'=>'July','month_number'=>7,'year'=>2024,'divisi'=>'Strategic Project & Infrastructure','dept'=>'Engineering & Capital Project','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Agus Riyanto','plan_job_title'=>'Business & Reporting Senior Analist','category_level'=>'Supervisor','gender'=>'Male','progress'=>'Failed - Interview','sourch'=>'Referral','sla'=>30,'month_name'=>'July','month_number'=>7,'year'=>2024,'divisi'=>'Commercial & IT','dept'=>'Commercial & IT','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Chario','plan_job_title'=>'Business & Reporting Senior Analist','category_level'=>'Supervisor','gender'=>'Male','progress'=>'Failed - Interview','priority'=>'P1','sourch'=>'Referral','sla'=>30,'month_name'=>'July','month_number'=>7,'year'=>2024,'divisi'=>'Commercial & IT','dept'=>'Commercial & IT','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Joko Triyanto','plan_job_title'=>'Scheduler Civil Senior Engineer','category_level'=>'Supervisor','gender'=>'Male','progress'=>'Failed - Interview','priority'=>'P1','sourch'=>'Referral','month_name'=>'July','month_number'=>7,'year'=>2024,'divisi'=>'Strategic Project & Infrastructure','dept'=>'Engineering & Capital Project','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'M. Ardan Ibrahim','plan_job_title'=>'Mine Development Operator','category_level'=>'Non-Staff','gender'=>'Male','progress'=>'Failed - Interview','priority'=>'P1','sourch'=>'Referral','sla'=>30,'month_name'=>'July','month_number'=>7,'year'=>2024,'divisi'=>'Strategic Project & Infrastructure','dept'=>'Mine Development','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Sarman','plan_job_title'=>'Mine Development Operator','category_level'=>'Non-Staff','gender'=>'Male','progress'=>'Failed - Interview','priority'=>'P1','sourch'=>'Referral','sla'=>30,'month_name'=>'July','month_number'=>7,'year'=>2024,'divisi'=>'Strategic Project & Infrastructure','dept'=>'Mine Development','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Marsel Palullungan','plan_job_title'=>'Mine Development Operator','category_level'=>'Non-Staff','gender'=>'Male','progress'=>'Failed - Interview','priority'=>'P1','sourch'=>'Referral','sla'=>30,'month_name'=>'July','month_number'=>7,'year'=>2024,'divisi'=>'Strategic Project & Infrastructure','dept'=>'Mine Development','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Yunus Pasae','plan_job_title'=>'Mine Development Operator','category_level'=>'Non-Staff','gender'=>'Male','progress'=>'Failed - Interview','priority'=>'P1','sourch'=>'Referral','sla'=>30,'month_name'=>'July','month_number'=>7,'year'=>2024,'divisi'=>'Strategic Project & Infrastructure','dept'=>'Mine Development','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Yusuf Sampe','plan_job_title'=>'Mine Development Operator','category_level'=>'Non-Staff','gender'=>'Male','progress'=>'Failed - Interview','priority'=>'P1','sourch'=>'Referral','sla'=>30,'month_name'=>'July','month_number'=>7,'year'=>2024,'divisi'=>'Strategic Project & Infrastructure','dept'=>'Mine Development','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'M. Khaeron','plan_job_title'=>'MEP Superintendent','category_level'=>'Assistant Manager','gender'=>'Male','progress'=>'Failed - Interview','priority'=>'NP','sourch'=>'Referral','month_name'=>'July','month_number'=>7,'year'=>2024,'divisi'=>'Strategic Project & Infrastructure','dept'=>'Engineering & Capital Project','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Ricky Andreas','plan_job_title'=>'MEP Senior Engineer','category_level'=>'Supervisor','gender'=>'Male','progress'=>'Failed - Interview','priority'=>'P1','sourch'=>'Referral','month_name'=>'July','month_number'=>7,'year'=>2024,'divisi'=>'Strategic Project & Infrastructure','dept'=>'Engineering & Capital Project','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Hengki Purnando','plan_job_title'=>'Production Engineer','category_level'=>'Officer','gender'=>'Male','progress'=>'Failed - Interview','priority'=>'P2','sourch'=>'Referral','sla'=>30,'month_name'=>'July','month_number'=>7,'year'=>2024,'divisi'=>'Operation','dept'=>'Production Engineering','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Muh. Afif Ishak','plan_job_title'=>'Grade Control Foreman','category_level'=>'Officer','gender'=>'Male','progress'=>'Failed - Interview','priority'=>'P1','sourch'=>'Referral','sla'=>30,'month_name'=>'July','month_number'=>7,'year'=>2024,'divisi'=>'Mine Geology & QA','dept'=>'Mine Geology','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Muh. Raihan','plan_job_title'=>'Grade Control Foreman','category_level'=>'Officer','gender'=>'Male','progress'=>'Failed - Interview','priority'=>'P1','sourch'=>'Referral','sla'=>30,'month_name'=>'July','month_number'=>7,'year'=>2024,'divisi'=>'Mine Geology & QA','dept'=>'Mine Geology','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Muhammad Sofyan','plan_job_title'=>'Hydrology Senior Engineer','category_level'=>'Supervisor','gender'=>'Male','progress'=>'Failed - Interview','priority'=>'P3','sourch'=>'Referral','sla'=>30,'month_name'=>'July','month_number'=>7,'year'=>2024,'divisi'=>'Mine Engineering','dept'=>'Geotech & Hydrology','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Rajab','plan_job_title'=>'Safety Hauling Patrol','category_level'=>'Non-Staff','gender'=>'Male','progress'=>'Failed - Interview','priority'=>'P2','sourch'=>'Referral','sla'=>30,'month_name'=>'August','month_number'=>8,'year'=>2024,'divisi'=>'OHS & Assets Protection','dept'=>'Occupational Health & Safety','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Zamla','plan_job_title'=>'Safety Hauling Patrol','category_level'=>'Non-Staff','gender'=>'Male','progress'=>'Failed - Interview','priority'=>'P2','sourch'=>'Referral','sla'=>30,'month_name'=>'August','month_number'=>8,'year'=>2024,'divisi'=>'OHS & Assets Protection','dept'=>'Occupational Health & Safety','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Heriaswin Malangi','plan_job_title'=>'Mine Engineer Specialist','category_level'=>'Supervisor','gender'=>'Male','progress'=>'Failed - Interview','priority'=>'P1','sourch'=>'LinkedIn','sla'=>30,'month_name'=>'August','month_number'=>8,'year'=>2024,'divisi'=>'Mine Engineering','dept'=>'Mine Engineering','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Agus Setyawan','plan_job_title'=>'Surveyor Leadhand','category_level'=>'Non-Staff','gender'=>'Male','progress'=>'Failed - Interview','priority'=>'P1','sourch'=>'Referral','sla'=>81,'month_name'=>'August','month_number'=>8,'year'=>2024,'divisi'=>'Operation','dept'=>'Survey','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Alam Tronics','plan_job_title'=>'Geotechnical & Hydrology Superintendent','category_level'=>'Assistant Manager','gender'=>'Male','progress'=>'Failed - Interview','priority'=>'P1','sourch'=>'LinkedIn','sla'=>30,'month_name'=>'August','month_number'=>8,'year'=>2024,'divisi'=>'Mine Engineering','dept'=>'Geotech & Hydrology','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Muhammad Fathin Firaz','plan_job_title'=>'Geotechnical & Hydrology Superintendent','category_level'=>'Assistant Manager','gender'=>'Male','progress'=>'Failed - Interview','priority'=>'P1','sourch'=>'LinkedIn','sla'=>30,'month_name'=>'August','month_number'=>8,'year'=>2024,'divisi'=>'Mine Engineering','dept'=>'Geotech & Hydrology','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Sanuddin','plan_job_title'=>'Surveyor Leadhand','category_level'=>'Non-Staff','gender'=>'Male','progress'=>'Failed - Interview','priority'=>'P1','sourch'=>'Referral','sla'=>81,'month_name'=>'August','month_number'=>8,'year'=>2024,'divisi'=>'Operation','dept'=>'Survey','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Adven Adi Saputra','plan_job_title'=>'Grade Control Foreman','category_level'=>'Officer','gender'=>'Male','progress'=>'Failed - Interview','priority'=>'P1','sourch'=>'Referral','sla'=>30,'month_name'=>'August','month_number'=>8,'year'=>2024,'divisi'=>'Mine Geology & QA','dept'=>'Mine Geology','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Muhammad Indra','plan_job_title'=>'Grade Control Foreman','category_level'=>'Officer','gender'=>'Male','progress'=>'Failed - Interview','sourch'=>'Referral','sla'=>30,'month_name'=>'August','month_number'=>8,'year'=>2024,'divisi'=>'Mine Geology & QA','dept'=>'Mine Geology','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Henri Sinaga','plan_job_title'=>'MEP Senior Engineer','category_level'=>'Supervisor','gender'=>'Male','progress'=>'Failed - Interview','sourch'=>'Referral','month_name'=>'August','month_number'=>8,'year'=>2024,'divisi'=>'Strategic Project & Infrastructure','dept'=>'Engineering & Capital Project','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Julius Sukarto','plan_job_title'=>'Road Maintenance Supervisor','category_level'=>'Supervisor','gender'=>'Male','progress'=>'Failed - Interview','priority'=>'P1','sourch'=>'Referral','sla'=>44,'month_name'=>'August','month_number'=>8,'year'=>2024,'divisi'=>'Ore Haulage','dept'=>'Road Maintenance','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Yan Adiguna Nastuion','plan_job_title'=>'Scheduler Civil Senior Engineer','category_level'=>'Supervisor','gender'=>'Male','progress'=>'Failed - Interview','priority'=>'P1','sourch'=>'Referral','month_name'=>'August','month_number'=>8,'year'=>2024,'divisi'=>'Strategic Project & Infrastructure','dept'=>'Engineering & Capital Project','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Joko Winarji','plan_job_title'=>'Mechanic','category_level'=>'Non-Staff','gender'=>'Male','progress'=>'Failed - Interview','sourch'=>'BSI','sla'=>30,'month_name'=>'June','month_number'=>6,'year'=>2024,'divisi'=>'General Facility & Maintenance','dept'=>'General Facility & Maintenance','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Hari Setyo Budi','plan_job_title'=>'Community Development Officer','category_level'=>'Officer','gender'=>'Male','progress'=>'Failed - Interview','sourch'=>'BSI','sla'=>30,'month_name'=>'August','month_number'=>8,'year'=>2024,'divisi'=>'Community Affairs','dept'=>'Community Affairs','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Pelipus Niko Moll','plan_job_title'=>'Mechanic','category_level'=>'Non-Staff','gender'=>'Male','progress'=>'Failed - Interview','sourch'=>'BSI','sla'=>30,'month_name'=>'June','month_number'=>6,'year'=>2024,'divisi'=>'General Facility & Maintenance','dept'=>'General Facility & Maintenance','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Adhyatma Damopolii','plan_job_title'=>'Media Relation Supervisor','category_level'=>'Supervisor','gender'=>'Male','progress'=>'Failed - Interview','sourch'=>'BSI','sla'=>30,'month_name'=>'August','month_number'=>8,'year'=>2024,'divisi'=>'Community Affairs','dept'=>'Community Affairs','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Ahmad Amiludin','plan_job_title'=>'Mine Development Operator','category_level'=>'Non-Staff','gender'=>'Male','progress'=>'Failed - Interview','sourch'=>'BSI','sla'=>30,'month_name'=>'August','month_number'=>8,'year'=>2024,'divisi'=>'Strategic Project & Infrastructure','dept'=>'Mine Development','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Arinta Wihandana','plan_job_title'=>'Reclamation & Revegetation Supervisor','category_level'=>'Supervisor','gender'=>'Male','progress'=>'Failed - Interview','sourch'=>'BSI','sla'=>30,'month_name'=>'August','month_number'=>8,'year'=>2024,'divisi'=>'Compliance & Environmental','dept'=>'Environmental Operation','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Bagas Andry Andika','plan_job_title'=>'Compliance & Reporting Officer','category_level'=>'Officer','gender'=>'Male','progress'=>'Failed - Interview','sourch'=>'BSI','sla'=>30,'month_name'=>'August','month_number'=>8,'year'=>2024,'divisi'=>'Compliance & Environmental','dept'=>'Compliance & Forestry','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Dedy Indrawan Daulay','plan_job_title'=>'Grade Control Pit Supervisor','category_level'=>'Supervisor','gender'=>'Male','progress'=>'Failed - Interview','sourch'=>'BSI','sla'=>30,'month_name'=>'August','month_number'=>8,'year'=>2024,'divisi'=>'Mine Geology & QA','dept'=>'Mine Geology','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Muslichin','plan_job_title'=>'Business & Reporting Superintendent','category_level'=>'Assistant Manager','gender'=>'Male','progress'=>'Failed - Interview','sourch'=>'BSI','sla'=>30,'month_name'=>'August','month_number'=>8,'year'=>2024,'divisi'=>'Commercial & IT','dept'=>'Commercial & IT','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Yasmina Saputri','plan_job_title'=>'Admin Production & Cost Engineering','category_level'=>'Non-Staff','gender'=>'Female','progress'=>'Failed - Interview','sourch'=>'BSI','sla'=>20,'month_name'=>'August','month_number'=>8,'year'=>2024,'divisi'=>'Operation','dept'=>'Production & Cost Engineering','status_ata'=>'Full Approval'],
            ['nama_lengkap'=>'Randy Arifia','plan_job_title'=>'Electrical Superintendent','category_level'=>'Assistant Manager','gender'=>'Male','progress'=>'Failed - Interview','priority'=>'P1','sourch'=>'Referral','sla'=>30,'month_name'=>'August','month_number'=>8,'year'=>2024,'divisi'=>'General Facility & Maintenance','dept'=>'General Facility & Maintenance','status_ata'=>'Full Approval'],
        ];

        foreach ($rows as $row) {
            $divisi = isset($row['divisi']) ? Divisi::where('nama', $row['divisi'])->first() : null;
            $dept   = isset($row['dept'])   ? Departemen::where('nama', $row['dept'])->first() : null;
            Rekrutmen::firstOrCreate(
                ['nama_lengkap' => $row['nama_lengkap'], 'plan_job_title' => $row['plan_job_title'], 'year' => $row['year']],
                [
                    'category_level' => $row['category_level'] ?? null,
                    'gender'         => $row['gender'] ?? null,
                    'progress'       => $row['progress'],
                    'priority'       => $row['priority'] ?? null,
                    'sourch'         => $row['sourch'] ?? null,
                    'sla'            => $row['sla'] ?? null,
                    'month_name'     => $row['month_name'],
                    'month_number'   => $row['month_number'],
                    'status_ata'     => $row['status_ata'] ?? null,
                    'divisi_id'      => $divisi?->id,
                    'departemen_id'  => $dept?->id,
                    'status'         => 'Closed',
                    'site'           => 'Konawe',
                ]
            );
        }
    }

    private function seedKaryawan(): void
    {
        $divGFM = Divisi::where('nama','General Facility & Maintenance')->first();
        $deptGFM = Departemen::where('nama','General Facility & Maintenance')->first();

        $staffSample = [
            ['nama'=>'Yanuar Ade Putra','salutation'=>'Mr.','position'=>'Estimator Civil Senior Analyst','level'=>'Supervisor','terms'=>'PKWTT','status'=>'Percobaan','grade'=>13,'tipe'=>'Staff'],
            ['nama'=>'Gayuh Satria','salutation'=>'Mr.','position'=>'Electrical Drafter','level'=>'Supervisor','terms'=>'PKWTT','status'=>'Percobaan','grade'=>13,'tipe'=>'Staff'],
            ['nama'=>'Fauzan Irfansyah','salutation'=>'Mr.','position'=>'Production Engineer','level'=>'Officer','terms'=>'PKWT','status'=>'Kontrak','grade'=>11,'tipe'=>'Staff'],
            ['nama'=>'Zainal Abidin','salutation'=>'Mr.','position'=>'Mekanik','level'=>'Non Staff','terms'=>'PKWT','status'=>'Kontrak','grade'=>null,'tipe'=>'Non-Staff'],
            ['nama'=>'Idul Febrianto','salutation'=>'Mr.','position'=>'Mekanik','level'=>'Non Staff','terms'=>'PKWT','status'=>'Kontrak','grade'=>null,'tipe'=>'Non-Staff'],
            ['nama'=>'Sry Danty Seak','salutation'=>'Mrs.','position'=>'Admin Infrastruktur','level'=>'Non Staff','terms'=>'PKWT','status'=>'Kontrak','grade'=>null,'tipe'=>'Non-Staff'],
        ];

        foreach ($staffSample as $s) {
            Karyawan::firstOrCreate(['nama'=>$s['nama'],'position'=>$s['position']], [
                'salutation' => $s['salutation'],
                'tipe'       => $s['tipe'],
                'level'      => $s['level'],
                'terms'      => $s['terms'],
                'status'     => $s['status'],
                'grade'      => $s['grade'],
                'divisi_id'  => $divGFM?->id,
                'departemen_id' => $deptGFM?->id,
                'work_location' => 'Konawe Site',
                'company'    => 'PT Sulawesi Cahaya Mineral',
                'basic_salary' => $s['tipe'] === 'Staff' ? 11000000 : 3500000,
                'signature_name'  => 'Endah Carolina',
                'signature_title' => 'HRGA Manager',
            ]);
        }
    }

    private function seedMpp(): void
    {
        $tahunList = [2024, 2025, 2026];
        $grades = [
            ['grade'=>'Officer','count'=>135],['grade'=>'Supervisor','count'=>129],
            ['grade'=>'Labour Supply','count'=>74],['grade'=>'Assistant Manager','count'=>71],
            ['grade'=>'Non-Staff','count'=>65],['grade'=>'Manager','count'=>38],
            ['grade'=>'Senior Manager','count'=>16],['grade'=>'General Manager','count'=>7],
            ['grade'=>'Executive Committee','count'=>4],
        ];

        $divisiMpp = [
            ['nama'=>'Compliance & Environmental','count'=>58],['nama'=>'General Facility & Maintenance','count'=>50],
            ['nama'=>'Exploration & Resources Development','count'=>43],['nama'=>'Strategic Project & Infrastructure','count'=>41],
            ['nama'=>'Commercial & IT','count'=>38],['nama'=>'OHS & Assets Protection','count'=>38],
            ['nama'=>'Operation','count'=>34],['nama'=>'Mine Geology & QA','count'=>31],
            ['nama'=>'Estate Management','count'=>31],['nama'=>'HRGA Operation','count'=>30],
        ];

        foreach ($tahunList as $tahun) {
            $idx = 1;
            foreach ($divisiMpp as $dm) {
                $divisi = Divisi::where('nama', $dm['nama'])->first();
                $gradeInfo = $grades[($idx - 1) % count($grades)];
                MppPosition::firstOrCreate(
                    ['tahun'=>$tahun,'job_title'=>'Posisi MPP '.$dm['nama'].' '.$tahun,'divisi_id'=>$divisi?->id],
                    [
                        'category_grade' => $gradeInfo['grade'],
                        'site'           => 'Konawe',
                        'mpp_jan'=>1,'mpp_feb'=>1,'mpp_mar'=>1,'mpp_apr'=>1,'mpp_may'=>1,'mpp_jun'=>1,
                        'mpp_jul'=>1,'mpp_aug'=>1,'mpp_sep'=>1,'mpp_oct'=>1,'mpp_nov'=>1,'mpp_dec'=>1,
                        'existing_jan'=>0,'existing_feb'=>0,'existing_mar'=>0,'existing_apr'=>1,
                        'existing_may'=>1,'existing_jun'=>1,'existing_jul'=>1,'existing_aug'=>1,
                        'existing_sep'=>1,'existing_oct'=>1,'existing_nov'=>1,'existing_dec'=>1,
                        'is_active'=>true,
                    ]
                );
                $idx++;
            }
        }
    }
}
