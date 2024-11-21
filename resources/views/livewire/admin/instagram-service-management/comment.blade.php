<section class="card p-5" x-data="form">
    <form autocomplete="off" wire:submit.prevent="submit" class="grid grid-cols-2 gap-5">
        <article>
            <div class="mb-4">
                <label class="block text-gray-600 mb-2 uppercase" for="url">URL</label>
                <input type="text" class="form-input w-full" id="url" wire:model="form.url"
                    placeholder="https://www.instagram.com/p/CwZyRTzvHj1">
            </div>
            <div class="mb-4">
                <label class="block text-gray-600 mb-2 uppercase" for="account_count">Number of Account</label>
                <input type="text" x-mask="999999" class="form-input w-full" id="account_count"
                    wire:model="form.account_count">
            </div>
            <div class="mb-4">
                <label class="block text-gray-600 uppercase" for="use_ai">Use AI</label>
                <small class=" mb-2">Use AI to generate 10 comments</small>
                <div class="flex items-center">
                    <input class="form-switch text-primary" wire:model.live="form.use_ai" type="checkbox"
                        id="use_ai">
                </div>
            </div>

            <button type="submit" x-show="!loading" x-on:click="save" class="btn bg-primary">
                Process Now
            </button>
        </article>
        <article>
            @if ($form['use_ai'])
                <div class="mb-4">
                    <label class="block text-gray-600 mb-2 uppercase" for="ai_message">Input Message</label>
                    <div class="flex items-end gap-5">
                        <textarea placeholder="Cantik, tampan atau hal lain yang menggambarkan postingan" id="ai_message" class="form-input"
                            cols="5" rows="5" x-model="prompt"></textarea>
                        <button type="button" x-show="!loading" class="btn bg-primary"
                            x-on:click="generateContent">Generate</button>
                        <button type="button" class="btn bg-primary" x-on:click="generateContent"
                            x-show="loading">Loading...</button>
                    </div>
                </div>
            @endif
            <label class="block text-gray-600 mb-2 uppercase" for="ai_message">Input Message</label>
            <ul class="mb-2">
                @foreach ($form['comments'] as $key => $item)
                    <li class="flex gap-2 items-center mb-2">
                        <input type="text" class="form-input" wire:model="form.comments.{{ $key }}">
                        <button type="button" wire:click="deleteComment('{{ $key }}')" class="text-primary">
                            <i class="mdi mdi-delete"></i></button>
                    </li>
                @endforeach
            </ul>
            <button class="btn bg-primary" type="button" wire:click="newComment">New Comment</button>
        </article>
    </form>
    @script
        <script>
            Alpine.data('form', () => ({
                prompt: '',
                loading: false,

                async generateContent() {
                    // Validasi input
                    if (!this.prompt) {
                        alert('Prompt tidak boleh kosong!');
                        return;
                    }

                    this.loading = true;

                    try {
                        // Panggil API Google Gemini
                        const response = await fetch(
                            'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=AIzaSyD0aCshDk4hBeZtuqd4nGonofJ7qSkBWQ8', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify({
                                    contents: [{
                                        parts: [{
                                            text: `Buatkan saya 10 kalimat komentar post instagram dengan kategori ini (${this.prompt}), dan pastikan returnnya adalah json dengan schema comments:, maksimal 100 karakter.`
                                        }],
                                    }],
                                    generationConfig: {
                                        response_mime_type: "application/json",
                                        response_schema: {
                                            "type": "object",
                                            "properties": {
                                                "comments": {
                                                    "type": "array",
                                                    "items": {
                                                        "type": "string"
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }),
                            }
                        );

                        const data = await response.json();
                        if (data.candidates && data.candidates.length > 0) {
                            // Ambil teks dari "candidates[0].content.parts[0].text"
                            const rawText = data.candidates[0].content.parts[0].text;
                            // Bersihkan teks dari wrapping markdown jika ada
                            const cleanedText = rawText
                                .trim() // Hapus spasi atau baris kosong di awal/akhir
                                .replace(/^```json\n/, '') // Hapus ` ```json\n ` di awal
                                .replace(/```$/, ''); // Hapus ` ``` ` di akhir // Hapus ``` di akhir


                            // // Parse teks menjadi JSON
                            const parsedResults = JSON.parse(cleanedText);
                            await $wire.setCommentFromAi(parsedResults.comments)
                        } else {
                            alert('Tidak ada hasil yang dikembalikan oleh API.');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Gagal terhubung ke API.');
                    } finally {
                        this.loading = false; // Sembunyikan loader
                    }
                },
                save(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Save & Process',
                        text: 'Are you sure?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        showLoaderOnConfirm: true,
                        allowOutsideClick: false,
                        preConfirm: async () => {
                            await $wire.submit();
                        }
                    });
                },
                init() {
                    $wire.on('swal:error', ({
                        message
                    }) => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: message,
                        });
                    });
                    $wire.on('swal:success', ({
                        message
                    }) => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: message,
                        });
                    });
                }
            }));
        </script>
    @endscript
</section>
