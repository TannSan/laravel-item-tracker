<div id="dps-club-sideblock">
   <a href="http://strokemywookie.com/pages/dps_club" rel="nofollow"><span class="title-text">DPS Club</span></a> <a href="http://strokemywookie.com/pages/dps_club" rel="nofollow">(Read More)</a>
   <br />
   @foreach ($top_3 as $parse)
      @if ($loop->first)
         <span class="class-text">1st</span> {{ $parse->member_name }} {{ floor($parse->parse_dps) }} {{ $parse->advanced_class }}</span>
      @else
         <span class="class-text">{{ $loop->iteration == 2 ? '2nd' : '3rd' }}</span> <span class="grey-text">{{ $parse->member_name }} {{ floor($parse->parse_dps) }} {{ $parse->advanced_class }}</span>
      @endif
      <br />
   @endforeach
   <br />
   <span class="class-text">Craziest</span> {{ $top_crazy->member_name }} {{ floor($top_crazy->parse_dps) }} {{ $top_crazy->advanced_class }}</span>
   <br />
   <br />
   <a href="http://strokemywookie.com/pages/dps_club" rel="nofollow"><span class="title-text">Damage Masters</span></a>
   <br />
   <span class="class-text">Assassin:</span> {{ $assassins->member_name }}</span>
   <br />
   <span class="class-text">Juggernaut:</span> {{ $juggernauts->member_name }}</span>
   <br />
   <span class="class-text">Marauder:</span> {{ $marauders->member_name }}</span>
   <br />
   <span class="class-text">Mercenary:</span> {{ $mercenaries->member_name }}</span>
   <br />
   <span class="class-text">Operative:</span> {{ $operatives->member_name }}</span>
   <br />
   <span class="class-text">Powertech:</span> {{ $powertechs->member_name }}</span>
   <br />
   <span class="class-text">Sniper:</span> {{ $snipers->member_name }}</span>
   <br />
   <span class="class-text">Sorcerer:</span> {{ $sorcerers->member_name }}</span>
</div>