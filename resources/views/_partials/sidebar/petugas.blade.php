<hr class="sidebar-divider">
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fa-solid fa-chart-simple"></i>
        <span>Riwayat Lelang</span>
    </a>
    <div id="collapseThree" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Data Terdiri:</h6>
            <a class="collapse-item {{ $title === 'Data Lelang' ? 'active' : '' }}" href="{{ url('/petugas/data/lelang') }}"><i class="fa-solid fa-magnifying-glass-dollar"></i> Data Lelang</a>
            <a class="collapse-item {{ $title === 'History Lelang' ? 'active' : '' }}" href="{{ url('/petugas/data/history/lelang/') }}"><i class="fas fa-clock"></i> History Lelang</a>
        </div>
    </div>
</li>
<hr class="sidebar-divider">
<li class="nav-item {{ $title === 'Data Barang' ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('/petugas/data/barang') }}">
        <i class="fa-solid fa-boxes-packing"></i>
        <span>Data Barang</span></a>
</li>