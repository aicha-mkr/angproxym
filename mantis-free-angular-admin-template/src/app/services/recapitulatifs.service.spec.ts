import { TestBed } from '@angular/core/testing';
import { RecapitulatifsService } from './recapitulatifs.service';

describe('RecapitulatifsService', () => {
  let service: RecapitulatifsService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(RecapitulatifsService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
