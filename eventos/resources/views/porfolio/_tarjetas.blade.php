@forelse ($projects as $project)
                <article class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition flex flex-col border border-stone-100">
                    @if ($project->image_url)
                   <img src="{{ $project->image_url }}" alt="{{ $project->title }}" class="h-48 w-full object-cover">
                    @else
                    <div class="h-48 bg-amber-100/50 flex items-center justify-center text-stone-400">
                        <span>📷 Sin foto</span>
                    </div>
                    @endif
                    
                    <div class="p-6 flex-grow flex flex-col justify-between">
                        <div>
                            <span class="inline-block bg-amber-50 text-amber-800 text-xs font-semibold px-2.5 py-1 rounded-full mb-3 uppercase tracking-wider">
                                {{ $project->category->name }}
                            </span>
                            <h3 class="text-lg font-bold text-stone-900 mb-2">{{ $project->title }}</h3>
                            <p class="text-stone-600 text-sm line-clamp-3 mb-4">{{ Str::limit($project->description, 100) }}</p>
                        </div>
                        
                        <div class="flex items-center justify-between pt-4 border-t border-stone-100 mt-auto text-xs text-stone-500">
                            @if($project->event_date)
                                <span>{{ $project->event_date->format('d/m/Y') }}</span>
                            @endif
                            <a href="{{ route('porfolio.show', $project->slug) }}" class="text-amber-700 font-semibold hover:underline">Ver galería &rarr;</a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-3 text-center py-12 text-stone-500 bg-white rounded-2xl border border-stone-100">
                    <p>Próximamente subiremos fotos de nuestros eventos más recientes.</p>
                </div>
            @endforelse