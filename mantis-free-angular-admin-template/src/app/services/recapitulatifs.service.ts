import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class RecapitulatifsService {
  private apiUrl = 'http://localhost:8000/api/recapitulatifs';

  constructor(private http: HttpClient) { }

  generateRecapitulatifs(): Observable<any> {
    return this.http.post<any>(`${this.apiUrl}/generate`, {});
  }
}
