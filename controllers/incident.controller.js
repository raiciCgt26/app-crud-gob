import { IncidentService } from "../services/incident.service.js";

class IncidentController extends IncidentService {
  constructor() {
    super();
  }

  createIncident(title) {
    title = title.toUpperCase();
    this.create(title);
  }
}

export const incidentController = new IncidentController();
