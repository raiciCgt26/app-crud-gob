import { Model } from "./model.js";

class IncidentService extends Model {
  constructor() {
    super();
  }

  async getAllIncidents() {
    return await this.execQuery("SELECT * FROM incidentes");
  }

  async create(title) {
    return await this.execQuery(
      `INSERT INTO \`incidentes\` (\`id\`, \`title\`) VALUES (NULL, '${title}')`,
      "incidentes",
      "id"
    );
  }
}

export const incidentService = new IncidentService();
