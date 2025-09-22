<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cars Report</title>
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
        .status-available { background-color: #d4edda; }
        .status-unavailable { background-color: #f8d7da; }
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
        <h1>Cars Report</h1>
        <p>Generated on: {{ now()->format('F d, Y \a\t H:i') }}</p>
        @if($status && $status !== 'all')
            <p>Filter: {{ ucfirst($status) }} Cars Only</p>
        @else
            <p>All Cars</p>
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
                <th>Car Name</th>
                <th>Plate Number</th>
                <th>Color</th>
                <th>Chassis Number</th>
                <th>Category</th>
                <th>Daily Rate</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cars as $car)
                <tr class="status-{{ $car->is_available ? 'available' : 'unavailable' }}">
                    <td><strong>{{ $car->name }}</strong></td>
                    <td>{{ $car->plate_number }}</td>
                    <td>{{ $car->color ?? 'N/A' }}</td>
                    <td>{{ $car->chassis_number ?? 'N/A' }}</td>
                    <td>{{ $car->category ? $car->category->name : 'N/A' }}</td>
                    <td>{{ $car->category && $car->category->daily_rate ? '$' . number_format($car->category->daily_rate, 2) : 'N/A' }}</td>
                    <td><strong>{{ $car->is_available ? 'Available' : 'Not Available' }}</strong></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <h3>Summary</h3>
        <p><strong>Total Cars:</strong> {{ $cars->count() }}</p>
        <p><strong>Available Cars:</strong> {{ $cars->where('is_available', true)->count() }}</p>
        <p><strong>Unavailable Cars:</strong> {{ $cars->where('is_available', false)->count() }}</p>
        
        @if($status === 'all' || !$status)
            <p><strong>Categories Breakdown:</strong></p>
            @php
                $categories = $cars->groupBy('category.name');
            @endphp
            @foreach($categories as $categoryName => $categoryCars)
                <p>• {{ $categoryName ?? 'No Category' }}: {{ $categoryCars->count() }} cars</p>
            @endforeach
        @endif
        
        @if($cars->count() > 0)
            @php
                $avgRate = $cars->avg(function($car) { 
                    return $car->category && $car->category->daily_rate ? $car->category->daily_rate : 0; 
                });
            @endphp
            <p><strong>Average Daily Rate:</strong> ${{ number_format($avgRate, 2) }}</p>
        @endif
    </div>
</body>
</html> 