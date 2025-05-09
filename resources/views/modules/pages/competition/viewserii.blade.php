<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Serii</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-4">
  <div class="max-w-5xl mx-auto">
    <h1 class="text-xl font-semibold mb-4">Serii</h1>

    <table class="min-w-full bg-white shadow rounded overflow-hidden text-sm">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-3 py-1 text-left uppercase tracking-wide">Serie</th>
          <th class="px-3 py-1 text-left uppercase tracking-wide">BIB</th>
          <th class="px-3 py-1 text-left uppercase tracking-wide">Person</th>
          <th class="px-3 py-1 text-left uppercase tracking-wide">Category</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        @foreach( collect($Serii)->groupBy('NrSerie') as $nrSerie => $rows )
          {{-- Group header: label in first column, empties for the rest --}}
          <tr class="bg-gray-100">
            <td  colspan="4" class="px-3 py-1 font-medium">Serie {{ $nrSerie }}</td>
            
          </tr>

          {{-- Detail rows: first cell blank so BIB lines up under its header --}}
          @foreach( $rows as $row )
            <tr>
              <td class="px-3 py-1"></td>
              <td class="px-3 py-1 whitespace-nowrap">{{ $row->BIB }}</td>
              <td class="px-3 py-1 whitespace-nowrap">{{ $row->Person }}</td>
              <td class="px-3 py-1 whitespace-nowrap">{{ $row->Category }}</td>
            </tr>
          @endforeach
        @endforeach
      </tbody>
    </table>
  </div>
</body>
</html>
