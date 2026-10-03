import fs from 'fs';
import { createCanvas, loadImage } from 'canvas';

async function removeBg() {
    const image = await loadImage('z:/CODES!!!! SSD/PHP Enverga/enverga-pass/public/images/seal-clean.png');
    const canvas = createCanvas(image.width, image.height);
    const ctx = canvas.getContext('2d');
    
    ctx.drawImage(image, 0, 0);
    const imgData = ctx.getImageData(0, 0, canvas.width, canvas.height);
    const data = imgData.data;

    for (let i = 0; i < data.length; i += 4) {
        const r = data[i];
        const g = data[i + 1];
        const b = data[i + 2];
        // If pixel color is near white background (RGB > 215)
        if (r > 210 && g > 210 && b > 210) {
            data[i + 3] = 0; // Make transparent
        }
    }

    ctx.putImageData(imgData, 0, 0);
    const out = fs.createWriteStream('z:/CODES!!!! SSD/PHP Enverga/enverga-pass/public/images/seal-transparent.png');
    const stream = canvas.createPNGStream();
    stream.pipe(out);
    out.on('finish', () => console.log('TRANSPARENT SEAL SAVED!'));
}

removeBg();
