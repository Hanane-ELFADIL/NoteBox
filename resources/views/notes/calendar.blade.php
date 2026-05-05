@extends('layouts.app')

@section('title', 'Calendrier - NoteBox')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow animate-fadeInUp">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-calendar3 me-2"></i>Calendrier des rappels
                    </h4>
                </div>
                <div class="card-body">
                    <div class="calendar-container">
                        <div class="calendar-header d-flex justify-content-between align-items-center mb-4">
                            <button class="btn btn-outline-primary" id="prevMonth">
                                <i class="bi bi-chevron-left"></i>
                            </button>
                            <h5 class="mb-0" id="currentMonth"></h5>
                            <button class="btn btn-outline-primary" id="nextMonth">
                                <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>
                        
                        <table class="table table-bordered calendar-table">
                            <thead>
                                <tr>
                                    <th>Lun</th>
                                    <th>Mar</th>
                                    <th>Mer</th>
                                    <th>Jeu</th>
                                    <th>Ven</th>
                                    <th>Sam</th>
                                    <th>Dim</th>
                                </tr>
                            </thead>
                            <tbody id="calendarBody">
                                <!-- Le calendrier sera généré par JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow animate-fadeInRight">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="bi bi-alarm me-2"></i>Rappels à venir
                    </h5>
                </div>
                <div class="card-body">
                    @if($notes->where('reminder_date', '>=', now())->count() > 0)
                        @foreach($notes->where('reminder_date', '>=', now())->sortBy('reminder_date') as $note)
                            <div class="alert alert-light border-start border-4 border-warning mb-3 animate-fadeInRight" style="animation-delay: {{ $loop->index * 0.1 }}s;">
                                <h6 class="alert-heading">
                                    <a href="{{ route('notes.show', $note) }}" class="text-decoration-none">{{ $note->title }}</a>
                                </h6>
                                <p class="mb-1">{{ Str::limit($note->content, 80) }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="bi bi-clock me-1"></i>{{ $note->reminder_date->format('d/m/Y à H:i') }}
                                    </small>
                                    @if($note->category)
                                        <span class="badge rounded-pill" style="background-color: {{ $note->category->color }};">
                                            {{ $note->category->name }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="bi bi-calendar-x display-4 mb-3"></i>
                            <p>Aucun rappel programmé</p>
                            <a href="{{ route('notes.create') }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-plus-circle me-1"></i>Créer une note avec rappel
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="card shadow mt-4 animate-fadeInRight" style="animation-delay: 0.2s;">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle-fill me-2"></i>Astuces
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <i class="bi bi-calendar-plus me-2 text-primary"></i>
                            Ajoutez des rappels à vos notes pour ne rien oublier
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-calendar-event me-2 text-success"></i>
                            Cliquez sur une date pour voir les notes associées
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-calendar-range me-2 text-warning"></i>
                            Naviguez entre les mois avec les flèches
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Données des notes avec rappels
    const notes = @json($notes->map(fn($note) => [
    'id' => $note->id,
    'title' => $note->title,
    'date' => $note->reminder_date?->format('Y-m-d'),
    'color' => $note->category?->color ?? '#007bff',
    'url' => route('notes.show', $note)
]));
    
    // Éléments du DOM
    const calendarBody = document.getElementById('calendarBody');
    const currentMonthElement = document.getElementById('currentMonth');
    const prevMonthButton = document.getElementById('prevMonth');
    const nextMonthButton = document.getElementById('nextMonth');
    
    // Date actuelle
    let currentDate = new Date();
    let currentMonth = currentDate.getMonth();
    let currentYear = currentDate.getFullYear();
    
    // Générer le calendrier
    function generateCalendar(month, year) {
        // Mettre à jour l'en-tête du mois
        const monthNames = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 
                           'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
        currentMonthElement.textContent = `${monthNames[month]} ${year}`;
        
        // Vider le corps du calendrier
        calendarBody.innerHTML = '';
        
        // Premier jour du mois (0 = Dimanche, 1 = Lundi, etc.)
        let firstDay = new Date(year, month, 1).getDay();
        // Convertir pour commencer par Lundi (0 = Lundi, 6 = Dimanche)
        firstDay = firstDay === 0 ? 6 : firstDay - 1;
        
        // Nombre de jours dans le mois
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        
        // Créer les cellules du calendrier
        let date = 1;
        for (let i = 0; i < 6; i++) {
            // Créer une ligne
            const row = document.createElement('tr');
            
            // Créer les cellules
            for (let j = 0; j < 7; j++) {
                const cell = document.createElement('td');
                
                if (i === 0 && j < firstDay) {
                    // Cellules vides avant le premier jour du mois
                    cell.classList.add('bg-light');
                } else if (date > daysInMonth) {
                    // Cellules vides après le dernier jour du mois
                    cell.classList.add('bg-light');
                } else {
                    // Cellules avec date
                    cell.textContent = date;
                    
                    // Vérifier si la date correspond à une note avec rappel
                    const currentDateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(date).padStart(2, '0')}`;
                    const notesForDay = notes.filter(note => note.date && note.date.startsWith(currentDateStr));
                    
                    if (notesForDay.length > 0) {
                        cell.classList.add('has-notes');
                        
                        // Ajouter des indicateurs pour chaque note
                        const noteIndicators = document.createElement('div');
                        noteIndicators.className = 'note-indicators';
                        
                        notesForDay.forEach(note => {
                            const indicator = document.createElement('a');
                            indicator.href = note.url;
                            indicator.className = 'note-indicator';
                            indicator.style.backgroundColor = note.color;
                            indicator.setAttribute('data-bs-toggle', 'tooltip');
                            indicator.setAttribute('title', note.title);
                            noteIndicators.appendChild(indicator);
                        });
                        
                        cell.appendChild(noteIndicators);
                    }
                    
                    // Mettre en évidence la date actuelle
                    if (date === new Date().getDate() && month === new Date().getMonth() && year === new Date().getFullYear()) {
                        cell.classList.add('bg-primary', 'text-white', 'today');
                    }
                    
                    date++;
                }
                
                row.appendChild(cell);
            }
            
            calendarBody.appendChild(row);
            
            // Arrêter si tous les jours du mois ont été ajoutés
            if (date > daysInMonth) {
                break;
            }
        }
        
        // Initialiser les tooltips
        const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltips.forEach(tooltip => new bootstrap.Tooltip(tooltip));
    }
    
    // Générer le calendrier initial
    generateCalendar(currentMonth, currentYear);
    
    // Événements pour les boutons de navigation
    prevMonthButton.addEventListener('click', function() {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        generateCalendar(currentMonth, currentYear);
    });
    
    nextMonthButton.addEventListener('click', function() {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        generateCalendar(currentMonth, currentYear);
    });
});
</script>
<style>
.calendar-table td {
    height: 80px;
    width: 14.28%;
    vertical-align: top;
    padding: 5px;
    position: relative;
    transition: all 0.3s ease;
}

.calendar-table td:hover {
    background-color: rgba(99, 102, 241, 0.1);
    transform: scale(1.05);
    z-index: 1;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.calendar-table .today {
    font-weight: bold;
    position: relative;
}

.calendar-table .today::after {
    content: "";
    position: absolute;
    bottom: 5px;
    left: 50%;
    transform: translateX(-50%);
    width: 5px;
    height: 5px;
    border-radius: 50%;
    background-color: white;
}

.note-indicators {
    display: flex;
    flex-wrap: wrap;
    gap: 3px;
    margin-top: 5px;
}

.note-indicator {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    display: inline-block;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease;
}

.note-indicator:hover {
    transform: scale(1.5);
}

.has-notes {
    background-color: rgba(0, 123, 255, 0.1);
}
</style>
@endpush
@endsection
