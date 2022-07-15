<!--
MIT License
Copyright (c) 2022 Aeo,
Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:
The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
-->

@extends('layouts.default', [
    'title' => 'Dashboard'
])

@section('content')
<div class="grid-x grid-margin-x">
			<div class="large-4 cell">
				<div class="dashboard-user-splash-color relative" style="background-color: #0A69BB; background: repeating-linear-gradient(45deg, #0A69BB, #0A69BB 10px, #034884 10px, #034884 20px);">
					<a href="/user/{{ Auth::user()->username }}">
						<div class="dashboard-user-avatar-thumb" style="background-image:url({{ Auth::user()->headshot() }});background-size:cover;"></div>
					</a>
				</div>
              <div class="dashboard-user-container">
					<a href="/user/{{ Auth::user()->username }}" class="dashboard-user-name">{{ Auth::user()->username }}</a>
    <div class="grid-x grid-margin-x">
						<div class="large-4 cell text-center">
                        <div class="dashboard-stat-large">0</div>
                        <div class="dashboard-stat-name">GAME VISITS</div>
                    </div>
                    <div class="large-4 cell text-center">
                        <div class="dashboard-stat-large">{{ number_format(Auth::user()->friends()->count()) }}</div>
                        <div class="dashboard-stat-name">FRIENDS</div>
                    </div>
                    <div class="large-4 cell text-center">
                        <div class="dashboard-stat-large">{{ number_format(Auth::user()->forumPostCount()) }}</div>
                        <div class="dashboard-stat-name">FORUM POSTS</div>
                    </div>
                </div>
            </div>
            <div class="push-25"></div>
				<h6>IMPORTANT UPDATES</h6>
				<div class="dashboard-container">
                 
                    @forelse ($updates as $update)
                        <div class="block">
                          
                            <a href="{{ route('forum.thread', $update->id) }}" class="very-bold dark-gray-text block ellipsis">{{ $update->title }}</a>
                            <div class="gray-text block status-block">by <b>{{ $update->creator->username }}</b></div>
                            <span class="bold light-gray-text status-time" title="{{ $update->created_at->diffForHumans() }}">{{ $update->created_at->format('d/m/Y h:i A') }}</span>
                        </div>
                        <div class="status-card-divider"></div>
                    @empty
                        <span>No updates found.</span>
                    @endforelse
                </div>
            </div>
  <div class="large-8 cell">
                    <form method="POST" action="#">
                        @csrf
                      <div class="error-message">Soon...</div>
                      
                        <div class="grid-x grid-margin-x align-middle">
						<div class="auto cell no-margin">
                          
                            <input name="message" class="dashboard-status-input" placeholder="How's it going, {{ Auth::user()->username }}?" type="text">      
                          </div>
                          
						<div class="shrink cell no-margin">
							<input type="submit" class="dashboard-status-submit" value="Post">
						</div>
                          
					</div>
				</form>
    
				<div class="push-25"></div>
				<div class="dashboard-container">
                  
                 
                    
    				</div>
			</div>
		</div>
@endsection
