   <div class="container" id="scoreboards">
      @for ($i = 0; $i < 8; $i++)
         @switch($i)
            @case(0)
               @php
                  $parse_class = 'Assassins';
                  $parse_arr = $assassins;
               @endphp
               @break
            @case(1)
               @php
                  $parse_class = 'Juggernauts';
                  $parse_arr = $juggernauts;
               @endphp
               @break
            @case(2)
               @php
                  $parse_class = 'Marauders';
                  $parse_arr = $marauders;
               @endphp
               @break
            @case(3)
               @php
                  $parse_class = 'Mercenaries';
                  $parse_arr = $mercenaries;
               @endphp
               @break
            @case(4)
               @php
                  $parse_class = 'Operatives';
                  $parse_arr = $operatives;
               @endphp
               @break
            @case(5)
               @php
                  $parse_class = 'Powertechs';
                  $parse_arr = $powertechs;
               @endphp
               @break
            @case(6)
               @php
                  $parse_class = 'Snipers';
                  $parse_arr = $snipers;
               @endphp
               @break
            @case(7)
               @php
                  $parse_class = 'Sorcerers';
                  $parse_arr = $sorcerers;
               @endphp
               @break
         @endswitch
         <div class="rank_dps" id="ranks_{{ strtolower($parse_class) }}">
            <h3>Top 5 {{ $parse_class }}</h3>
            <table class="damage_table">
               @foreach ($parse_arr as $parse)
               <tr{{ $loop->first ? ' class=damage_table_champion' : '' }}>
                  <td><a href="{{ $parse->forum_link }}" title="{{ $parse->member_name }}: Last updated {{ date('jS M Y', strtotime($parse->parse_date)) }}">{{ $parse->member_name }}</a></td>
                  <td><a href="{{ $parse->parse_link }}">{{ floor($parse->parse_dps) }}</a></td>
                  <td>{{ str_replace('Innovative Ordnance', 'IO', str_replace('Advanced Prototype', 'AP', $parse->specialization)) }}</td>
               </tr>
               @endforeach
            </table>
         </div>
      @endfor
      @for ($i = 0; $i < 2; $i++)
         @switch($i)
            @case(0)
               @php
                  $table_title = 'Top 40 Parses';
                  $div_id = 'ranks_all';
                  $parse_arr = $top_40;
               @endphp
               @break
            @case(1)
               @php
                  $table_title = 'Top 40 Crazy Parses';
                  $div_id = 'ranks_all_crazy';
                  $parse_arr = $top_40_crazy;
               @endphp
               @break
         @endswitch
         <div class="rank_dps" id="{{ $div_id }}">
            <h3>{{ $table_title }}</h3>
            <table class="damage_table">
               @foreach ($parse_arr as $parse)
               <tr{{ $loop->first ? ' class=damage_table_champion' : '' }}>
                  <td>{{ $loop->iteration }}</td>
                  <td><a href="{{ $parse->forum_link}}" title="{{ $parse->member_name }}: Last updated {{ date('jS M Y', strtotime($parse->parse_date)) }}">{{ $parse->member_name }}</a></td>
                  <td><a href="{{ $parse->parse_link}}">{{ $parse->parse_dps }}</a></td>
                  <td>{{ $parse->advanced_class }}</td>
                  <td>{{ str_replace('Innovative Ordnance', 'IO', str_replace('Advanced Prototype', 'AP', $parse->specialization)) }}</td>
               </tr>
               @endforeach
            </table>
         </div>
      @endfor
   </div>