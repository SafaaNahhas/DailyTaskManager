<h1 style="font-family: Arial, sans-serif; color: #4CAF50;">مهامك المعلقة لهذا اليوم</h1>
<p style="font-family: Arial, sans-serif; color: #333;">
    عزيزي {{ $user->name }}, لديك المهام التالية التي لم تكتمل بعد:
</p>

<table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif;">
    <thead>
        <tr>
            <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2; text-align: left;">المهمة</th>
            <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2; text-align: left;">تاريخ الاستحقاق</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tasks as $task)
            <tr>
                <td style="border: 1px solid #ddd; padding: 8px;">{{ $task->title }}</td>
                <td style="border: 1px solid #ddd; padding: 8px;">{{ $task->due_date }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<p style="font-family: Arial, sans-serif; color: #333;">
    يرجى إكمال المهام بأسرع وقت.
</p>
