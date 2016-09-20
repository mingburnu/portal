<tr>
    <td>
        @if(!empty($mark))
            {{$mark}}
        @endif
        {{ $menu->title }}</td>
    <td>
        @if( $menu->view == 1)
            是
        @else
            否
        @endif
    </td>
    <td>{{ $menu->rank_id }}</td>
    <td>{{ $menu->created_at }}</td>
    <td>{{ $menu->updated_at }}</td>
    <td>
        <a class="btn_03"
           href="{{ $url = route('paper.browser.id.delete', ['id' => $menu->id ] ) }}">刪除</a>
        <a class="btn_02"
           href="{{ $url = route('paper.edit.id', ['id' => $menu->id ] )}}">修改</a>
    </td>
</tr>

@if (count($menu['children']) > 0)
    @foreach($menu['children'] as $menu)

        <?php $record = "";
        $parent = $menu['parent'];

        while ($parent != null) {
            $record = $record . '└ ';
            $parent = $parent->parent;
        }
        ?>

        @include('layout.tree', ['menu'=>$menu,'mark'=>$record])

    @endforeach
@endif