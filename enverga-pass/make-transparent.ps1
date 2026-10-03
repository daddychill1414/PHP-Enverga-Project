[Reflection.Assembly]::LoadWithPartialName("System.Drawing")
$path = "z:\CODES!!!! SSD\PHP Enverga\enverga-pass\public\images\seal.png"
$outPath = "z:\CODES!!!! SSD\PHP Enverga\enverga-pass\public\images\seal-transparent.png"
$img = [System.Drawing.Image]::FromFile($path)
$bmp = New-Object System.Drawing.Bitmap($img)
$bmp.MakeTransparent([System.Drawing.Color]::White)
$bmp.Save($outPath, [System.Drawing.Imaging.ImageFormat]::Png)
Write-Host "SUCCESS"
