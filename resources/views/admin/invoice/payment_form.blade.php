<div>
    <div class="row">
        <div class="col-md-4">
            <span><strong>Invoice #: </strong> {{ $invoice->invoice_number }}</span>
        </div>
        <div class="col-md-4">
            <span><strong>Total: </strong> {{ $invoice->grand_total }}</span>
        </div>
        <div class="col-md-4">
            <span><strong>Due Date: </strong>
                {{ \Carbon\Carbon::parse($invoice->due_date)->format('d-m-Y') }}
            </span>
        </div>
    </div>

    <hr>
    @if($invoice->is_paid == 0)

    <form id="updatePaymentForm">
        @csrf
        <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">

        <div class="row g-3">
            <div class="col-md-3">
                <label>Amount</label>
                <input type="number" name="amount" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label>Payment Method</label>
                <select name="payment_method" class="form-control" required>
                    @foreach(\App\Enums\PaymentMethod::values() as $type)
                    <option value="{{ $type }}">{{ $type }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label>Remarks</label>
                <input type="text" name="remarks" class="form-control" placeholder="Enter remarks (optional)">
            </div>
            <div class="form-check mt-3" style="margin-left: 10px;">
                <input class="form-check-input" type="checkbox" value="1" name="is_full_payment" id="is_full_payment">
                <label class="form-check-label" for="is_full_payment">
                    Is Full Total Payment Received? (Update Invoice To Paid)
                </label>
            </div>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-success">Add Payment</button>
        </div>
    </form>
    <hr>
    @endif
    <h6>Collected Payments:</h6>
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>#</th>
                <th>Date & Time</th>
                <th>Amount</th>
                <th>Payment Method</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @php $totalCollected = 0; @endphp
            @forelse($payments as $index => $pay)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($pay->payment_datetime)->format('d-m-Y H:i:s') }}</td>
                <td>{{ $pay->amount }}</td>
                <td>{{ ucfirst($pay->payment_method) }}</td>
                <td>{{ $pay->remarks }}</td>
            </tr>
            @php $totalCollected += $pay->amount; @endphp
            @empty
            <tr>
                <td colspan="5" class="text-center">No payments yet</td>
            </tr>
            @endforelse

            <!-- Total collected row -->
            <tr>
                <td colspan="2" class="text-end"><strong>Total Collected:</strong></td>
                <td colspan="3"><strong>{{ $totalCollected }}</strong></td>
            </tr>
        </tbody>
    </table>


</div>