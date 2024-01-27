<div id="editschedule" class="page_content page_content_master ">
        <h2>Program tragere</h2>

        <form class="" action="changeschedule" method="POST">
            @csrf
            <input Name = "CompetitionId" id="CompetitionId" value="{{$CompetitionId}}" hidden>
            <div class="row">
                <div class="col-md-2"><label>Ora\Poligon</label></div>
                @foreach ($poligoane as $p)
                    <label>{{$p->Name}}</label>
                @endforeach
                </select>
            </div>    
        </form>
</div>