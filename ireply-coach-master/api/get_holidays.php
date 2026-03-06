<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Philippine holidays for 2024-2025
$philippineHolidays = [
    // 2024
    ['date' => '2024-01-01', 'name' => 'New Year\'s Day', 'kind' => 'Holiday'],
    ['date' => '2024-02-10', 'name' => 'Chinese New Year', 'kind' => 'Holiday'],
    ['date' => '2024-02-12', 'name' => 'Chinese New Year (Observed)', 'kind' => 'Holiday'],
    ['date' => '2024-02-13', 'name' => 'Chinese New Year Holiday', 'kind' => 'Holiday'],
    ['date' => '2024-02-25', 'name' => 'EDSA Revolution Anniversary', 'kind' => 'Holiday'],
    ['date' => '2024-03-28', 'name' => 'Maundy Thursday', 'kind' => 'Holiday'],
    ['date' => '2024-03-29', 'name' => 'Good Friday', 'kind' => 'Holiday'],
    ['date' => '2024-03-30', 'name' => 'Black Saturday', 'kind' => 'Holiday'],
    ['date' => '2024-04-09', 'name' => 'Day of Valor', 'kind' => 'Holiday'],
    ['date' => '2024-04-10', 'name' => 'Eid\'l Fitr', 'kind' => 'Holiday'],
    ['date' => '2024-06-12', 'name' => 'Independence Day', 'kind' => 'Holiday'],
    ['date' => '2024-06-17', 'name' => 'Eid\'l Adha', 'kind' => 'Holiday'],
    ['date' => '2024-08-21', 'name' => 'Ninoy Aquino Day', 'kind' => 'Holiday'],
    ['date' => '2024-08-26', 'name' => 'National Heroes Day', 'kind' => 'Holiday'],
    ['date' => '2024-11-01', 'name' => 'All Saints\' Day', 'kind' => 'Holiday'],
    ['date' => '2024-11-30', 'name' => 'Bonifacio Day', 'kind' => 'Holiday'],
    ['date' => '2024-12-08', 'name' => 'Feast of the Immaculate Conception', 'kind' => 'Holiday'],
    ['date' => '2024-12-25', 'name' => 'Christmas Day', 'kind' => 'Holiday'],
    ['date' => '2024-12-30', 'name' => 'Rizal Day', 'kind' => 'Holiday'],
    ['date' => '2024-12-31', 'name' => 'New Year\'s Eve', 'kind' => 'Holiday'],
    
    // 2025
    ['date' => '2025-01-01', 'name' => 'New Year\'s Day', 'kind' => 'Holiday'],
    ['date' => '2025-01-29', 'name' => 'Chinese New Year', 'kind' => 'Holiday'],
    ['date' => '2025-01-30', 'name' => 'Chinese New Year (Observed)', 'kind' => 'Holiday'],
    ['date' => '2025-01-31', 'name' => 'Chinese New Year Holiday', 'kind' => 'Holiday'],
    ['date' => '2025-02-25', 'name' => 'EDSA Revolution Anniversary', 'kind' => 'Holiday'],
    ['date' => '2025-04-09', 'name' => 'Day of Valor', 'kind' => 'Holiday'],
    ['date' => '2025-04-17', 'name' => 'Maundy Thursday', 'kind' => 'Holiday'],
    ['date' => '2025-04-18', 'name' => 'Good Friday', 'kind' => 'Holiday'],
    ['date' => '2025-04-19', 'name' => 'Black Saturday', 'kind' => 'Holiday'],
    ['date' => '2025-06-12', 'name' => 'Independence Day', 'kind' => 'Holiday'],
    ['date' => '2025-08-21', 'name' => 'Ninoy Aquino Day', 'kind' => 'Holiday'],
    ['date' => '2025-09-01', 'name' => 'National Heroes Day', 'kind' => 'Holiday'],
    ['date' => '2025-11-01', 'name' => 'All Saints\' Day', 'kind' => 'Holiday'],
    ['date' => '2025-11-30', 'name' => 'Bonifacio Day', 'kind' => 'Holiday'],
    ['date' => '2025-12-08', 'name' => 'Feast of the Immaculate Conception', 'kind' => 'Holiday'],
    ['date' => '2025-12-25', 'name' => 'Christmas Day', 'kind' => 'Holiday'],
    ['date' => '2025-12-30', 'name' => 'Rizal Day', 'kind' => 'Holiday'],
    
    // 2026
    ['date' => '2026-01-01', 'name' => 'New Year\'s Day', 'kind' => 'Holiday'],
    ['date' => '2026-02-17', 'name' => 'Chinese New Year', 'kind' => 'Holiday'],
    ['date' => '2026-02-18', 'name' => 'Chinese New Year (Observed)', 'kind' => 'Holiday'],
    ['date' => '2026-02-19', 'name' => 'Chinese New Year Holiday', 'kind' => 'Holiday'],
    ['date' => '2026-02-25', 'name' => 'EDSA Revolution Anniversary', 'kind' => 'Holiday'],
    ['date' => '2026-04-09', 'name' => 'Day of Valor', 'kind' => 'Holiday'],
    ['date' => '2026-04-02', 'name' => 'Maundy Thursday', 'kind' => 'Holiday'],
    ['date' => '2026-04-03', 'name' => 'Good Friday', 'kind' => 'Holiday'],
    ['date' => '2026-04-04', 'name' => 'Black Saturday', 'kind' => 'Holiday'],
    ['date' => '2026-06-12', 'name' => 'Independence Day', 'kind' => 'Holiday'],
    ['date' => '2026-08-21', 'name' => 'Ninoy Aquino Day', 'kind' => 'Holiday'],
    ['date' => '2026-09-07', 'name' => 'National Heroes Day', 'kind' => 'Holiday'],
    ['date' => '2026-11-01', 'name' => 'All Saints\' Day', 'kind' => 'Holiday'],
    ['date' => '2026-11-30', 'name' => 'Bonifacio Day', 'kind' => 'Holiday'],
    ['date' => '2026-12-08', 'name' => 'Feast of the Immaculate Conception', 'kind' => 'Holiday'],
    ['date' => '2026-12-25', 'name' => 'Christmas Day', 'kind' => 'Holiday'],
    ['date' => '2026-12-30', 'name' => 'Rizal Day', 'kind' => 'Holiday'],
];

// Get current date
$currentDate = new DateTime();
$currentMonth = (int)$currentDate->format('m');
$currentYear = (int)$currentDate->format('Y');

// Determine next month
$nextMonth = $currentMonth + 1;
$nextYear = $currentYear;
if ($nextMonth > 12) {
    $nextMonth = 1;
    $nextYear = $currentYear + 1;
}

$holidays = [];

foreach ($philippineHolidays as $holiday) {
    $holidayDate = new DateTime($holiday['date']);
    $holidayMonth = (int)$holidayDate->format('m');
    $holidayYear = (int)$holidayDate->format('Y');
    
    // Check if holiday is in current month or next month
    if (($holidayYear === $currentYear && $holidayMonth === $currentMonth) ||
        ($holidayYear === $nextYear && $holidayMonth === $nextMonth)) {
        $holidays[] = [
            'id' => md5($holiday['date']),
            'label' => $holiday['name'],
            'date' => $holidayDate->format('M d'),
            'kind' => $holiday['kind'],
            'fullDate' => $holiday['date']
        ];
    }
}

// Sort by date
usort($holidays, function($a, $b) {
    return strtotime($a['fullDate']) - strtotime($b['fullDate']);
});

echo json_encode(["status" => "success", "data" => $holidays]);
?>
