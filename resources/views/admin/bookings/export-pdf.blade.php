<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bookings Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #333;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 10px;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .status-pending { background-color: #fff3cd; }
        .status-confirmed { background-color: #d1ecf1; }
        .status-taken { background-color: #cce5ff; }
        .status-completed { background-color: #d4edda; }
        .status-cancelled { background-color: #f8d7da; }
        .summary {
            margin-top: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
        }
        .summary h3 {
            margin: 0 0 10px 0;
            color: #333;
        }
        .summary p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Bookings Report</h1>
        <p>Generated on: {{ now()->format('F d, Y \a\t H:i') }}</p>
        @if($status && $status !== 'all')
            <p>Filter: {{ ucfirst($status) }} Bookings Only</p>
        @else
            <p>All Bookings</p>
        @endif
        @if(isset($fromDate) && $fromDate)
            <p>From Date: {{ \Carbon\Carbon::parse($fromDate)->format('F d, Y') }}</p>
        @endif
        @if(isset($toDate) && $toDate)
            <p>To Date: {{ \Carbon\Carbon::parse($toDate)->format('F d, Y') }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>Reference</th>
                <th>Customer</th>
                <th>Phone</th>
                <th>Car/Category</th>
                <th>Driver</th>
                <th>Destination</th>
                <th>Pickup Date</th>
                <th>Return Date</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Organization</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
                <tr class="status-{{ $booking->status }}">
                    <td><strong>{{ $booking->reference_number }}</strong></td>
                    <td>{{ $booking->customer_name }}</td>
                    <td>{{ $booking->customer_phone }}</td>
                    <td>
                        @if($booking->car)
                            {{ $booking->car->name }}<br>
                            <small>{{ $booking->car->plate_number }}</small>
                        @elseif($booking->category)
                            {{ $booking->category->name }} (Category)
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $booking->driver ? $booking->driver->name : 'N/A' }}</td>
                    <td>
                        @if($booking->destination === 'out of the city')
                            Out of City - {{ $booking->region }}
                        @else
                            {{ ucfirst($booking->destination) }}
                        @endif
                    </td>
                                                        <td>{{ $booking->pickup_date->format('M d, Y g:i A') }}</td>
                                                        <td>{{ $booking->return_date->format('M d, Y g:i A') }}</td>
                    <td>${{ number_format($booking->total_amount, 2) }}</td>
                    <td><strong>{{ ucfirst($booking->status) }}</strong></td>
                    <td>{{ $booking->organization ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <h3>Summary</h3>
        <p><strong>Total Bookings:</strong> {{ $bookings->count() }}</p>
        <p><strong>Total Revenue:</strong> ${{ number_format($bookings->sum('total_amount'), 2) }}</p>
        <p><strong>Average Booking Value:</strong> ${{ $bookings->count() > 0 ? number_format($bookings->avg('total_amount'), 2) : '0.00' }}</p>
        
        @if($status === 'all' || !$status)
            <p><strong>Status Breakdown:</strong></p>
            <p>• Pending: {{ $bookings->where('status', 'pending')->count() }}</p>
            <p>• Taken: {{ $bookings->where('status', 'taken')->count() }}</p>
            <p>• Completed: {{ $bookings->where('status', 'completed')->count() }}</p>
        @endif
    </div>
</body>
</html> 