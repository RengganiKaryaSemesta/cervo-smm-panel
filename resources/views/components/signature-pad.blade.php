<div x-data="signaturePad('{{ $attributes['wire:model'] }}')" class="mb-2">
    <label for="signature" class="block text-gray-600 mb-2">Signature</label>
    <canvas x-ref="canvas" class="border-2 w-full border-dashed"></canvas>
    <div class="mt-2 flex items-center">
        <button @click="clear" type="button" class="bg-red-500 text-white px-4 py-2">Clear</button>
        <label for="uploadSignature" style="line-height: inherit">
            <div class="bg-blue-500 text-white px-4 py-2">Upload</div>
            <input type="file" id="uploadSignature" @change="uploadImage" accept="image/*"
                class="border px-4 py-2 hidden" />
        </label>
    </div>
    <small>If you choose to upload an image, make sure the background is transparent and the signature is
        black.</small>
</div>
@script
    <script>
        Alpine.data('signaturePad', (model) => ({
            canvas: null,
            ctx: null,
            drawing: false,
            signature: null,
            init() {
                this.canvas = this.$refs.canvas;
                this.ctx = this.canvas.getContext('2d');
                this.canvas.width = this.canvas.offsetWidth;
                this.canvas.height = this.canvas.offsetHeight;
                this.$wire.on('signature:init', ({
                    data
                }) => {
                    this.clear()
                    if (data) {
                        this.signature = data
                        this.loadImage(this.signature)
                    }
                })
                // Mengatur ketebalan garis dan rounded ends untuk menggambar lebih halus
                this.ctx.lineWidth = 2; // Sesuaikan ketebalan sesuai kebutuhan
                this.ctx.lineCap = 'round'; // Membulatkan ujung garis agar lebih halus

                this.canvas.addEventListener('mousedown', this.startDrawing.bind(this));
                this.canvas.addEventListener('mouseup', this.stopDrawing.bind(this));
                this.canvas.addEventListener('mousemove', this.throttle(this.draw.bind(this),
                    10));

                this.canvas.addEventListener('touchstart', this.startDrawing.bind(this));
                this.canvas.addEventListener('touchend', this.stopDrawing.bind(this));
                this.canvas.addEventListener('touchmove', this.throttle(this.draw.bind(this),
                    10));

            },
            uploadImage(event) {
                const file = event.target.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = (e) => {
                    const img = new Image();
                    img.onload = () => {
                        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
                        this.ctx.drawImage(img, 0, 0, this.canvas.width, this.canvas
                            .height);
                        this.save();
                    };
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            startDrawing(event) {
                this.drawing = true;
                this.ctx.beginPath();
                this.ctx.moveTo(this.getMousePos(event).x, this.getMousePos(event).y);
            },

            stopDrawing() {
                this.drawing = false;
                this.save()
            },

            draw(event) {
                if (!this.drawing) return;

                const pos = this.getMousePos(event);

                this.ctx.lineTo(pos.x, pos.y);
                this.ctx.stroke();
                this.ctx.beginPath();
                this.ctx.moveTo(pos.x, pos.y);
            },

            async clear() {
                this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
                await this.$wire.set(model, null)
            },

            async save() {
                const dataURL = this.canvas.toDataURL('image/png');
                await this.$wire.set(model, dataURL)
            },

            getMousePos(event) {
                const rect = this.canvas.getBoundingClientRect();
                const scaleX = this.canvas.width / rect.width;
                const scaleY = this.canvas.height / rect.height;

                if (event.touches) {
                    return {
                        x: (event.touches[0].clientX - rect.left) * scaleX,
                        y: (event.touches[0].clientY - rect.top) * scaleY
                    };
                } else {
                    return {
                        x: (event.clientX - rect.left) * scaleX,
                        y: (event.clientY - rect.top) * scaleY
                    };
                }
            },
            loadImage(dataURL) {
                const img = new Image();
                img.onload = () => {
                    this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
                    this.ctx.drawImage(img, 0, 0, this.canvas.width, this.canvas.height);
                };
                img.src = dataURL;
            },
            throttle(func, limit) {
                let lastFunc;
                let lastRan;
                return function(...args) {
                    const context = this;
                    if (!lastRan) {
                        func.apply(context, args);
                        lastRan = Date.now();
                    } else {
                        clearTimeout(lastFunc);
                        lastFunc = setTimeout(function() {
                            if ((Date.now() - lastRan) >= limit) {
                                func.apply(context, args);
                                lastRan = Date.now();
                            }
                        }, limit - (Date.now() - lastRan));
                    }
                };
            }
        }));
    </script>
@endscript
