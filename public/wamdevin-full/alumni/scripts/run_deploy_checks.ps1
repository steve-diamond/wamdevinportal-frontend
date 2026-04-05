Set-StrictMode -Version Latest
$ErrorActionPreference = 'Stop'

Write-Host "Running WAMDEVIN alumni preflight..." -ForegroundColor Cyan
php .\alumni\scripts\preflight.php
$preflightExit = $LASTEXITCODE

Write-Host "Running WAMDEVIN alumni post-deploy smoke checks..." -ForegroundColor Cyan
php .\alumni\scripts\post_deploy_smoke.php
$smokeExit = $LASTEXITCODE

if ($preflightExit -eq 0 -and $smokeExit -eq 0) {
    Write-Host "All deployment checks passed." -ForegroundColor Green
    exit 0
}

Write-Host "Deployment checks failed. Review output above." -ForegroundColor Red
exit 1
