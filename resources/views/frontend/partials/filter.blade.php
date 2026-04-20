<form method="GET" class="filter-bar mb-4">

    <div class="row g-2">

        <!-- SEARCH -->
        <div class="col-md-4">
            <input type="text" name="search"
                   value="{{ request('search') }}"
                   class="form-control"
                   placeholder="Search...">
        </div>

        <!-- STORE -->
        <div class="col-md-3">
            <select name="store" class="form-control">
                <option value="">All Stores</option>
                @foreach($stores ?? [] as $s)
                    <option value="{{ $s->id }}" {{ request('store') == $s->id ? 'selected' : '' }}>
                        {{ $s->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- CATEGORY -->
        <div class="col-md-3">
            <select name="category" class="form-control">
                <option value="">All Categories</option>
                @foreach($categories ?? [] as $c)
                    <option value="{{ $c->id }}" {{ request('category') == $c->id ? 'selected' : '' }}>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- BUTTON -->
        <div class="col-md-2">
            <button class="btn btn-gradient w-100">Apply Filter</button>
        </div>

    </div>

</form>