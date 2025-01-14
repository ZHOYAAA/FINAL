<x-layout :$menu :$submenu :$categories :$appname>
    <div class="container py-5">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Detail Pembayaran</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive mb-4">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Jumlah</th>
                                        <th class="text-end">Harga</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transaction->transactionDetails as $detail)
                                    <tr>
                                        <td>{{ $detail->product->title }}</td>
                                        <td>{{ $detail->quantity }}</td>
                                        <td class="text-end">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                                        <td class="text-end">Rp {{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-end">Total:</th>
                                        <th class="text-end">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="d-grid gap-2">
                            <button id="pay-button" class="btn btn-primary btn-lg">
                                Bayar Sekarang
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Midtrans Client Key -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>

    <script>
        const payButton = document.querySelector('#pay-button');
        payButton.addEventListener('click', function(e) {
            e.preventDefault();

            snap.pay('{{ $snapToken }}', {
                // Optional
                onSuccess: function(result) {
                    window.location.href = '/transaction/success';
                },
                onPending: function(result) {
                    window.location.href = '/transaction/pending';
                },
                onError: function(result) {
                    window.location.href = '/transaction/error';
                }
            });
        });
    </script>
</x-layout> 