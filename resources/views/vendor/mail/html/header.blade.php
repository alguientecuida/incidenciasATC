<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) !== 'Laravel')
<img src="https://www.alguientecuida.cl/wp-content/uploads/2022/04/logo-web.jpg" class="logo" alt="Laravel Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
