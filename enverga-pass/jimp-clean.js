import { readFileSync, writeFileSync } from 'fs';
import { Jimp } from 'jimp';

async function processBg() {
    const buffer = readFileSync('z:/CODES!!!! SSD/PHP Enverga/enverga-pass/public/images/seal-clean.png');
    const image = await Jimp.read(buffer);
    
    image.scan(0, 0, image.bitmap.width, image.bitmap.height, function(x, y, idx) {
        const red = this.bitmap.data[idx + 0];
        const green = this.bitmap.data[idx + 1];
        const blue = this.bitmap.data[idx + 2];

        if (red > 200 && green > 200 && blue > 200) {
            this.bitmap.data[idx + 3] = 0; // Make transparent
        }
    });

    const outBuffer = await image.getBuffer('image/png');
    writeFileSync('z:/CODES!!!! SSD/PHP Enverga/enverga-pass/public/images/seal-transparent.png', outBuffer);
    console.log('TRANSPARENT SEAL SAVED SUCCESSFULLY');
}

processBg();
