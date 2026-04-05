# Simple PowerShell test script to POST to membership-ajax-handler.php and show response + tail of the log
param(
    [string]$Url = 'http://127.0.0.1:8001/membership-ajax-handler.php',
    [string]$PhpRoot = 'C:\xampp\htdocs\wamdevin'
)

Write-Host "Posting test application to $Url`n" -ForegroundColor Cyan
$response = Invoke-RestMethod -Uri $Url -Method Post -Form @{
    instName = 'CLI Test Institute'
    contactName = 'PS Tester'
    contactEmail = 'pstester@example.com'
    contactPhone = '+111222333'
    plan = 'standard'
}

Write-Host "Response:`n" -ForegroundColor Green
$response | ConvertTo-Json -Depth 3 | Write-Host

$log = Join-Path $PhpRoot 'membership-submissions.log'
Write-Host "`nTail of log ($log):`n" -ForegroundColor Yellow
Get-Content $log -Tail 20 | ForEach-Object { Write-Host $_ }
